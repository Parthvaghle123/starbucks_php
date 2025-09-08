<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\AuthModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;

class AdminController extends BaseController
{
    protected $adminModel;
    protected $userModel;
    protected $orderModel;
    protected $orderItemModel;
    protected $productModel;
    use ResponseTrait;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->userModel = new AuthModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        return redirect()->to('/admin/login');
    }

    public function login()
    {
        if (session()->get('AdminLoginId')) {
            return redirect()->to('/admin/dashboard');
        }

        return view('admin/login');
    }

    public function authenticate()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $admin = $this->adminModel->where('email', $email)->first();

        if ($admin && password_verify($password, $admin['password'])) {
            session()->set([
                'AdminLoginId' => $admin['id'],
                'AdminName' => $admin['username']
            ]);

            return redirect()->to('/admin/dashboard');
        } else {
            session()->setFlashdata('error', 'Invalid email or password');
            return redirect()->back();
        }
    }

    public function dashboard()
    {
        if (!session()->get('AdminLoginId')) {
            return redirect()->to('/admin/login');
        }

        $recentOrdersRaw = $this->orderModel->orderBy('Date', 'DESC')->findAll(5);
        $recentOrders = [];

        foreach ($recentOrdersRaw as $order) {
            $items = $this->orderItemModel->where('order_id', $order['id'])->findAll();
            $total = 0;
            foreach ($items as $item) {
                $total += $item['Price'] * $item['Quantity'];
            }

            $recentOrders[] = [
                'id' => $order['id'],
                'username' => $order['username'],
                'Date' => $order['Date'],
                'Status' => $order['Status'],
                'total' => $total
            ];
        }

        $data = [
            'totalUsers' => $this->userModel->countAllResults(),
            'totalOrders' => $this->orderModel->countAllResults(),
            'totalRevenue' => $this->calculateTotalRevenue(),
            'recentOrders' => $recentOrders,
        ];

        return view('admin/dashboard', $data);
    }

    private function calculateTotalRevenue()
    {
        $items = $this->orderItemModel->findAll();
        $totalRevenue = 0;

        foreach ($items as $item) {
            $totalRevenue += $item['Price'] * $item['Quantity'];
        }

        return $totalRevenue;
    }

    public function users()
    {
        if (!session()->get('AdminLoginId')) {
            return redirect()->to('/admin/login');
        }
        return view('admin/users');
    }

    // API endpoint to get all users
    public function apiUsers()
    {
        if (!session()->get('AdminLoginId')) {
            return $this->failUnauthorized('Admin not logged in.');
        }

        $db = \Config\Database::connect();

        $builder = $db->table('login l')
            ->select('l.id, l.username, l.email, l.created_at, s.phone, s.gender, s.dob')
            ->join('sign s', 's.username = l.username', 'left')
            ->orderBy('l.id', 'DESC');

        $users = $builder->get()->getResultArray();

        foreach ($users as &$u) {
            if (!empty($u['dob'])) {
                try {
                    $birth = new \DateTime($u['dob']);
                    $now = new \DateTime();
                    $u['age'] = $now->diff($birth)->y;
                } catch (\Exception $e) {
                    $u['age'] = 'N/A';
                }
            } else {
                $u['age'] = 'N/A';
            }

            if (empty($u['phone'])) $u['phone'] = 'N/A';
            if (empty($u['gender'])) $u['gender'] = 'N/A';
        }

        return $this->respond($users);
    }

    // Delete User
    public function deleteUser($userId = null)
    {
        if (!session()->get('AdminLoginId')) {
            return $this->failUnauthorized('Admin not logged in.');
        }

        if ($userId === null) {
            return $this->fail('User ID is missing.', 400);
        }

        $db = \Config\Database::connect();

        try {
            // Log the deletion attempt
            log_message('info', "Attempting to delete user with ID: " . $userId);

            // Get username first
            $row = $db->table('login')->select('username')->where('id', $userId)->get()->getRowArray();

            if (!$row) {
                log_message('error', "User with ID {$userId} not found");
                return $this->failNotFound('User not found.');
            }

            $username = $row['username'];
            log_message('info', "Found user to delete: " . $username);

            // Start transaction for data integrity
            $db->transBegin();

            $loginDeleteResult = 0;
            $signDeleteResult = 0;

            try {
                // Delete from sign table first (profile data)
                log_message('info', "Attempting to delete from sign table with username: " . $username);
                $signDeleteResult = $db->table('sign')->where('username', $username)->delete();
                log_message('info', "Sign table deletion result: {$signDeleteResult} rows affected");

                // Delete from login table (main user record) - this is the most important
                log_message('info', "Attempting to delete from login table with ID: " . $userId);
                $loginDeleteResult = $db->table('login')->where('id', $userId)->delete();
                log_message('info', "Login table deletion result: {$loginDeleteResult} rows affected");

                // Check if the main login record was deleted
                if ($loginDeleteResult === 0) {
                    // Try to check if the record actually exists
                    $checkUser = $db->table('login')->where('id', $userId)->get()->getRowArray();
                    if ($checkUser) {
                        throw new \Exception("User still exists in login table after deletion attempt");
                    } else {
                        log_message('info', "User was already deleted or does not exist");
                    }
                }

                // Commit the transaction
                $db->transCommit();
                log_message('info', "User deletion transaction completed successfully");

                // Double-check that both records are actually gone
                $loginCheck = $db->table('login')->where('id', $userId)->countAllResults();
                $signCheck = $db->table('sign')->where('username', $username)->countAllResults();

                log_message('info', "Post-deletion verification - Login records remaining: {$loginCheck}, Sign records remaining: {$signCheck}");
            } catch (\Exception $e) {
                $db->transRollback();
                log_message('error', "Transaction failed: " . $e->getMessage());
                throw $e;
            }

            return $this->respondDeleted([
                'success' => true,
                'message' => 'User deleted successfully.',
                'deletedFromLogin' => $loginDeleteResult > 0,
                'deletedFromSign' => $signDeleteResult > 0,
                'username' => $username,
                'details' => [
                    'login_affected_rows' => $loginDeleteResult,
                    'sign_affected_rows' => $signDeleteResult,
                    'login_records_remaining' => $loginCheck ?? 'unknown',
                    'sign_records_remaining' => $signCheck ?? 'unknown'
                ]
            ]);
        } catch (\Exception $e) {
            log_message('error', 'User deletion error: ' . $e->getMessage());
            log_message('error', 'Error details: ' . $e->getFile() . ' line ' . $e->getLine());
            return $this->failServerError('Failed to delete user: ' . $e->getMessage());
        }
    }

    // Alternative delete method without transactions
    public function deleteUserSimple($userId = null)
    {
        if (!session()->get('AdminLoginId')) {
            return $this->failUnauthorized('Admin not logged in.');
        }

        if ($userId === null) {
            return $this->fail('User ID is missing.', 400);
        }

        $db = \Config\Database::connect();

        try {
            log_message('info', "Simple deletion attempt for user ID: " . $userId);

            // Get username first
            $row = $db->table('login')->select('username')->where('id', $userId)->get()->getRowArray();

            if (!$row) {
                log_message('error', "User with ID {$userId} not found");
                return $this->failNotFound('User not found.');
            }

            $username = $row['username'];
            log_message('info', "Found user to delete: " . $username);

            // Delete from sign table first (without transaction)
            log_message('info', "Deleting from sign table...");
            $signDeleteResult = $db->table('sign')->where('username', $username)->delete();
            log_message('info', "Sign table deletion: {$signDeleteResult} rows affected");

            // Delete from login table
            log_message('info', "Deleting from login table...");
            $loginDeleteResult = $db->table('login')->where('id', $userId)->delete();
            log_message('info', "Login table deletion: {$loginDeleteResult} rows affected");

            // Verify deletions
            $loginCheck = $db->table('login')->where('id', $userId)->countAllResults();
            $signCheck = $db->table('sign')->where('username', $username)->countAllResults();

            log_message('info', "Verification - Login remaining: {$loginCheck}, Sign remaining: {$signCheck}");

            return $this->respondDeleted([
                'success' => true,
                'message' => 'User deleted successfully (simple method).',
                'deletedFromLogin' => $loginDeleteResult > 0,
                'deletedFromSign' => $signDeleteResult > 0,
                'username' => $username,
                'details' => [
                    'login_affected_rows' => $loginDeleteResult,
                    'sign_affected_rows' => $signDeleteResult,
                    'login_records_remaining' => $loginCheck,
                    'sign_records_remaining' => $signCheck
                ]
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Simple user deletion error: ' . $e->getMessage());
            return $this->failServerError('Failed to delete user: ' . $e->getMessage());
        }
    }

    // Test method to check database connectivity and table structure
    public function testDatabase()
    {
        if (!session()->get('AdminLoginId')) {
            return $this->failUnauthorized('Admin not logged in.');
        }

        $db = \Config\Database::connect();

        try {
            $result = [
                'database_connection' => 'OK',
                'database_name' => $db->getDatabase(),
                'tables' => [],
                'login_table_test' => null,
                'sign_table_test' => null
            ];

            // Test table listing
            $tables = $db->listTables();
            $result['tables'] = $tables;

            // Test login table
            if (in_array('login', $tables)) {
                $loginCount = $db->table('login')->countAllResults();
                $result['login_table_test'] = "Exists with {$loginCount} records";
            } else {
                $result['login_table_test'] = "Does not exist";
            }

            // Test sign table
            if (in_array('sign', $tables)) {
                $signCount = $db->table('sign')->countAllResults();
                $result['sign_table_test'] = "Exists with {$signCount} records";
            } else {
                $result['sign_table_test'] = "Does not exist";
            }

            return $this->respond($result);
        } catch (\Exception $e) {
            return $this->failServerError('Database test failed: ' . $e->getMessage());
        }
    }

    public function orders()
    {
        if (!session()->get('AdminLoginId')) {
            return redirect()->to('/admin/login');
        }

        // The React component directly fetches data via API, so this view just needs to load the HTML structure.
        return view('admin/orders');
    }
    // API endpoint to get all orders with their items
    public function apiOrders()
    {
        if (!session()->get('AdminLoginId')) {
            return $this->failUnauthorized('Admin not logged in.');
        }

        try {
            $ordersData = $this->orderModel->orderBy('Date', 'DESC')->findAll();
            $formattedOrders = [];

            foreach ($ordersData as $order) {
                $items = $this->orderItemModel->where('order_id', $order['id'])->findAll();
                $total = 0;
                foreach ($items as $item) {
                    $total += $item['Price'] * $item['Quantity'];
                }

                $formattedOrders[] = [
                    '_id' => $order['id'], // React uses _id, so map CI4's 'id' to '_id'
                    'orderId' => $order['id'], // Use CI4's 'id' as orderId
                    'username' => $order['username'],
                    'email' => $order['Email'],
                    'phone' => $order['Phone'],
                    'address' => $order['Address'],
                    'paymentMethod' => $order['Pay_Mode'],
                    'status' => $order['Status'],
                    'createdAt' => $order['Date'], // React uses createdAt, map CI4's 'Date'
                    'total' => $total,
                    'items' => array_map(function ($item) {
                        return [
                            'name' => $item['Item_Name'],
                            'quantity' => $item['Quantity'],
                            'price' => $item['Price']
                        ];
                    }, $items)
                ];
            }
            return $this->respond($formattedOrders);
        } catch (\Exception $e) {
            return $this->failServerError('Server Error: ' . $e->getMessage());
        }
    }

    // API endpoint to update an order status
    public function updateOrderStatus($orderId = null)
    {
        if (!session()->get('AdminLoginId')) {
            return $this->failUnauthorized('Admin not logged in.');
        }

        if ($orderId === null) {
            return $this->fail('Order ID is missing.', 400);
        }

        // Accept status from multiple sources (JSON, form-data, query) and provide a safe default
        $input = $this->request->getRawInput();
        $jsonInput = (array) ($this->request->getJSON(true) ?? []);
        $status = $input['status']
            ?? $jsonInput['status']
            ?? $this->request->getVar('status')
            ?? 'Cancelled';

        $validStatuses = ['Pending', 'Approved', 'Cancelled'];
        if (!in_array($status, $validStatuses)) {
            return $this->fail('Invalid status provided.', 400);
        }

        try {
            $updated = $this->orderModel->update($orderId, ['Status' => $status, 'Date' => date('Y-m-d H:i:s')]); // Update 'Date' to reflect last update time

            if ($updated) {
                return $this->respondUpdated(['success' => true, 'message' => 'Order status updated successfully.', 'orderId' => $orderId, 'newStatus' => $status]);
            } else {
                return $this->failNotFound('Order not found or could not be updated.');
            }
        } catch (\Exception $e) {
            return $this->failServerError('Failed to update order status: ' . $e->getMessage());
        }
    }
    public function products()
    {
        if (!session()->get('AdminLoginId')) {
            return redirect()->to('/admin/login');
        }

        return view('admin/products');
    }

    // API endpoint to get all products
    public function apiProducts()
    {
        if (!session()->get('AdminLoginId')) {
            return $this->failUnauthorized('Admin not logged in.');
        }

        try {
            $products = $this->productModel->orderBy('created_at', 'DESC')->findAll();
            return $this->respond($products);
        } catch (\Exception $e) {
            return $this->failServerError('Server Error: ' . $e->getMessage());
        }
    }

    // API endpoint to add a new product
    public function addProduct()
    {
        if (!session()->get('AdminLoginId')) {
            return $this->failUnauthorized('Admin not logged in.');
        }

        try {
            $data = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'price' => $this->request->getPost('price'),
                'category' => $this->request->getPost('category'),
                'image' => $this->request->getPost('image'),
                'page' => $this->request->getPost('page')
            ];

            // Validate required fields
            if (empty($data['name']) || empty($data['price']) || empty($data['page'])) {
                return $this->failValidationError('Name, price, and page are required fields.');
            }

            // Validate price format
            if (!is_numeric($data['price']) || $data['price'] <= 0) {
                return $this->failValidationError('Price must be a positive number.');
            }

            // Validate page value
            if (!in_array($data['page'], ['menu', 'gift'])) {
                return $this->failValidationError('Page must be either "menu" or "gift".');
            }

            $productId = $this->productModel->insert($data);
            
            if ($productId) {
                $newProduct = $this->productModel->find($productId);
                return $this->respondCreated([
                    'success' => true,
                    'message' => 'Product added successfully.',
                    'product' => $newProduct
                ]);
            } else {
                return $this->failServerError('Failed to add product.');
            }
        } catch (\Exception $e) {
            return $this->failServerError('Server Error: ' . $e->getMessage());
        }
    }

    // API endpoint to update a product
    public function updateProduct($productId = null)
    {
        if (!session()->get('AdminLoginId')) {
            return $this->failUnauthorized('Admin not logged in.');
        }

        if ($productId === null) {
            return $this->fail('Product ID is missing.', 400);
        }

        try {
            $data = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'price' => $this->request->getPost('price'),
                'category' => $this->request->getPost('category'),
                'image' => $this->request->getPost('image'),
                'page' => $this->request->getPost('page')
            ];

            // Validate required fields
            if (empty($data['name']) || empty($data['price']) || empty($data['page'])) {
                return $this->failValidationError('Name, price, and page are required fields.');
            }

            // Validate price format
            if (!is_numeric($data['price']) || $data['price'] <= 0) {
                return $this->failValidationError('Price must be a positive number.');
            }

            // Validate page value
            if (!in_array($data['page'], ['menu', 'gift'])) {
                return $this->failValidationError('Page must be either "menu" or "gift".');
            }

            $updated = $this->productModel->update($productId, $data);
            
            if ($updated) {
                $updatedProduct = $this->productModel->find($productId);
                return $this->respondUpdated([
                    'success' => true,
                    'message' => 'Product updated successfully.',
                    'product' => $updatedProduct
                ]);
            } else {
                return $this->failNotFound('Product not found or could not be updated.');
            }
        } catch (\Exception $e) {
            return $this->failServerError('Server Error: ' . $e->getMessage());
        }
    }

    // API endpoint to delete a product
    public function deleteProduct($productId = null)
    {
        if (!session()->get('AdminLoginId')) {
            return $this->failUnauthorized('Admin not logged in.');
        }

        if ($productId === null) {
            return $this->fail('Product ID is missing.', 400);
        }

        try {
            $deleted = $this->productModel->delete($productId);
            
            if ($deleted) {
                return $this->respondDeleted([
                    'success' => true,
                    'message' => 'Product deleted successfully.',
                    'productId' => $productId
                ]);
            } else {
                return $this->failNotFound('Product not found or could not be deleted.');
            }
        } catch (\Exception $e) {
            return $this->failServerError('Server Error: ' . $e->getMessage());
        }
    }

    // API endpoint to get a single product
    public function getProduct($productId = null)
    {
        if (!session()->get('AdminLoginId')) {
            return $this->failUnauthorized('Admin not logged in.');
        }

        if ($productId === null) {
            return $this->fail('Product ID is missing.', 400);
        }

        try {
            $product = $this->productModel->find($productId);
            
            if ($product) {
                return $this->respond($product);
            } else {
                return $this->failNotFound('Product not found.');
            }
        } catch (\Exception $e) {
            return $this->failServerError('Server Error: ' . $e->getMessage());
        }
    }

    public function logout()
    {
        session()->remove(['AdminLoginId', 'AdminName']);
        return redirect()->to('/admin/login');
    }
}
