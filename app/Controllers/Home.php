<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ProductModel;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }
    public function gift()
    {
        return view('auth/gift'); // View file: app/Views/auth/gift.php
    }
    public function menu()
    {
        return view('auth/menu'); // View file: app/Views/auth/gift.php
    }
      public function checkout()
    {
        $username = session()->get('username');

        if (!$username) {
            return redirect()->to('/login')->with('error', 'Please login first');
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->getUserByUsername($username);

        return view('auth/checkout', ['user' => $user]);
    }

    // Debug method to see all products in database
    public function debugProducts()
    {
        try {
            $productModel = new ProductModel();
            $allProducts = $productModel->findAll();
            
            $debugInfo = [
                'total_products' => count($allProducts),
                'products' => $allProducts
            ];
            
            return $this->response->setJSON($debugInfo);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => 'Failed to fetch products for debugging',
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    // API endpoint to get all products for frontend
    public function apiProducts()
    {
        try {
            $productModel = new ProductModel();
            
            // Get page parameter from query string
            $page = $this->request->getGet('page');
            
            // If page is specified, filter by it
            if ($page && in_array($page, ['menu', 'gift'])) {
                $products = $productModel->where('page', $page)->orderBy('created_at', 'DESC')->findAll();
            } else {
                // If no page specified, return all products
                $products = $productModel->orderBy('created_at', 'DESC')->findAll();
            }
            
            // Format products for frontend
            $formattedProducts = [];
            foreach ($products as $product) {
                $formattedProducts[] = [
                    'id' => $product['id'],
                    'image' => $product['image'] ?: 'https://via.placeholder.com/300x300?text=No+Image',
                    'title' => $product['name'],
                    'per' => $product['description'] ?: 'No description available',
                    'price' => floatval($product['price']),
                    'category' => $product['category'] ?: 'General',
                    'page' => $product['page'] ?: 'menu'
                ];
            }
            
            return $this->response->setJSON($formattedProducts);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => 'Failed to fetch products',
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    // API endpoint to get menu products only
    public function apiMenuProducts()
    {
        try {
            $productModel = new ProductModel();
            
            // Get all products first to debug
            $allProducts = $productModel->findAll();
            
            // Filter products by page (case-insensitive)
            $products = [];
            foreach ($allProducts as $product) {
                if (strtolower($product['page']) === 'menu') {
                    $products[] = $product;
                }
            }
            
            // Format products for frontend
            $formattedProducts = [];
            foreach ($products as $product) {
                $formattedProducts[] = [
                    'id' => $product['id'],
                    'image' => $product['image'] ?: 'https://via.placeholder.com/300x300?text=No+Image',
                    'title' => $product['name'],
                    'per' => $product['description'] ?: 'No description available',
                    'price' => floatval($product['price']),
                    'category' => $product['category'] ?: 'General',
                    'page' => $product['page'] ?: 'menu'
                ];
            }
            
            return $this->response->setJSON($formattedProducts);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => 'Failed to fetch menu products',
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    // API endpoint to get gift products only
    public function apiGiftProducts()
    {
        try {
            $productModel = new ProductModel();
            
            // Get all products first to debug
            $allProducts = $productModel->findAll();
            
            // Filter products by page (case-insensitive)
            $products = [];
            foreach ($allProducts as $product) {
                if (strtolower($product['page']) === 'gift') {
                    $products[] = $product;
                }
            }
            
            // Format products for frontend
            $formattedProducts = [];
            foreach ($products as $product) {
                $formattedProducts[] = [
                    'id' => $product['id'],
                    'image' => $product['image'] ?: 'https://via.placeholder.com/300x300?text=No+Image',
                    'title' => $product['name'],
                    'per' => $product['description'] ?: 'No description available',
                    'price' => floatval($product['price']),
                    'category' => $product['category'] ?: 'General',
                    'page' => $product['page'] ?: 'gift'
                ];
            }
            
            return $this->response->setJSON($formattedProducts);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => 'Failed to fetch gift products',
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function manage_cart()
{
    $session = session();

    $itemName = $this->request->getPost('Item_Name');
    $itemPrice = $this->request->getPost('Price');
    $itemImage = $this->request->getPost('Item_Image');

    $cart = $session->get('cart') ?? [];

    $found = false;
    foreach ($cart as &$item) {
        if ($item['Item_Name'] === $itemName) {
            $item['Quantity'] += 1;
            $found = true;
            break;
        }
    }
    unset($item);

    if (!$found) {
        $cart[] = [
            'Item_Name' => $itemName,
            'Price' => $itemPrice,
            'Image' => $itemImage,
            'Quantity' => 1
        ];
    }

    $session->set('cart', $cart);

    // ✅ Return cart count also
    return $this->response->setJSON([
        'status' => 'success',
        'count' => count($cart)
    ]);
}

    public function update_cart()
{
    $session = session();

    // Remove item logic
    if ($this->request->getPost('Remove_Item') !== null) {
        $itemName = $this->request->getPost('Item_Name');

        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $item) {
                if ($item['Item_Name'] === $itemName) {
                    unset($_SESSION['cart'][$key]);
                    $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array
                    break;
                }
            }
        }
    }

    // Update quantity logic
    if ($this->request->getPost('Mod_Quantity') !== null) {
        $itemName = $this->request->getPost('Item_Name');
        $quantity = (int)$this->request->getPost('Mod_Quantity');

        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $item) {
                if ($item['Item_Name'] === $itemName) {
                    $_SESSION['cart'][$key]['Quantity'] = $quantity;
                    break;
                }
            }
        }
    }

    // ✅ Redirect after update or remove
    return redirect()->to('/mycart');
}


    // Home.php (અથવા CartController.php)
public function mycart()
{
    $cart = session()->get('cart') ?? [];
    $total = 0;

    foreach ($cart as $item) {
        // Check if Price and Quantity exist before using
        $price = isset($item['Price']) ? (int)$item['Price'] : 0;
        $qty = isset($item['Quantity']) ? (int)$item['Quantity'] : 1;
        $total += $price * $qty;
    }

    return view('auth/mycart', [
        'cart' => $cart,
        'total' => $total,
        'count' => count($cart)
    ]);
}

    public function index1()
    {
        if (!session()->get('username')) {
            return redirect()->to('/login')->with('error', 'Please login to continue');
        }

        return view('home');
    }

    public function placeOrder()
    {
        if (!session()->get('username')) {
            return redirect()->to('/login')->with('error', 'Please login first');
        }

        $db = \Config\Database::connect();

        $username = session()->get('username');
        $email = $this->request->getPost('email');
        $phone = $this->request->getPost('phone');
        $address = $this->request->getPost('address');
        $pay_mode = $this->request->getPost('pay_mode');
        $card_number = $this->request->getPost('card_number') ?: null;
        $expiry = $this->request->getPost('expiry') ?: null;
        $cvv = $this->request->getPost('cvv') ?: null;
        $date = date('Y-m-d');

        // ✅ Insert into order_manager
        $builder = $db->table('order_manager');
        $builder->insert([
            'Email' => $email,
            'Phone' => $phone,
            'Address' => $address,
            'Pay_Mode' => $pay_mode,
            'username' => $username,
            'Card_Number' => $card_number,
            'Card_Expiry' => $expiry,
            'CVV' => $cvv,
            'Date' => $date,
            'Status' => 'Approved'
        ]);

        $order_id = $db->insertID();

        // ✅ Insert items into user_order table
        $cart = session()->get('cart');

        if (!empty($cart)) {
            $builder = $db->table('user_order');
            foreach ($cart as $item) {
                $builder->insert([
                    'Order_Id' => $order_id,
                    'Item_Name' => $item['Item_Name'],
                    'Price' => $item['Price'],
                    'Quantity' => $item['Quantity'],
                    'Status' => 'Approved'
                ]);
            }

            session()->remove('cart'); // Clear cart after placing order

            return view('auth/order_success');
        } else {
            return redirect()->to('/mycart')->with('error', 'Cart is empty');
        }
    }
    public function orders()
    {
        if (!session()->get('username')) {
            return redirect()->to('/login')->with('error', 'Please login to view your orders');
        }

        $db = \Config\Database::connect();
        $username = session()->get('username');

        // Fetch orders from order_manager
        $orders = $db->table('order_manager')
            ->where('username', $username)
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();

        // Fetch items from user_order linked by Order_Id
        $orderItems = [];
        foreach ($orders as $order) {
            $items = $db->table('user_order')
                ->where('Order_Id', $order['id'])
                ->get()
                ->getResultArray();

            $orderItems[$order['id']] = $items;
        }

        return view('auth/orders', [
            'orders' => $orders,
            'orderItems' => $orderItems
        ]);
    }
    public function cancelOrder()
    {
        $orderId = $this->request->getPost('order_id');
        $reason = $this->request->getPost('cancel_reason');

        if ($reason === 'Someone any Reason') {
            $reason = $this->request->getPost('custom_reason');
        }

        $db = \Config\Database::connect();

        // ✅ Fix column name from 'Order_Id' to 'id' for order_manager
        $db->table('order_manager')
            ->where('id', $orderId)
            ->update([
                'Status' => 'Cancelled',
                'Reason' => $reason
            ]);

        // ✅ user_order table still uses Order_Id (keep as-is)
        $db->table('user_order')
            ->where('Order_Id', $orderId)
            ->update([
                'Status' => 'Cancelled'
            ]);

        return redirect()->to('/orders');
    }
}
