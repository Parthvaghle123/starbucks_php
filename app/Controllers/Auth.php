<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\UserModel;

class Auth extends BaseController
{
    // -------------------- REGISTER --------------------
    public function register()
    {
        return view('auth/register');
    }

    public function store()
    {
        $model = new AuthModel();

        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

        if ($model->isUsernameExists($username)) {
            return redirect()->back()->with('error', 'Username already exists');
        }

        // Save login credentials
        $model->save([
            'username' => $username,
            'email'    => $email,
            'password' => $password
        ]);

        // Calculate age from DOB
        $dob = $this->request->getPost('dob');
        $dobDate = new \DateTime($dob);
        $today = new \DateTime();
        $age = $today->diff($dobDate)->y;

        // Save sign details
        $signData = [
            'username' => $username,
            'email'    => $email,
            'phone'    => $this->request->getPost('country_code') . $this->request->getPost('phone'),
            'gender'   => $this->request->getPost('gender'),
            'dob'      => $dob,
            'age'      => $age,
            'address'  => $this->request->getPost('address'),
        ];

        $model->insertSignDetails($signData);

        return redirect()->to('/login')->with('success', 'Registration successful');
    }

    // -------------------- LOGIN --------------------
    public function login()
    {
        return view('auth/login');
    }

    public function loginAuth()
    {
        $session = session();
        $model = new AuthModel();

        $input = $this->request->getPost('email'); // from form input
        $password = $this->request->getPost('password');

        $user = $model->where('username', $input)
                      ->orWhere('email', $input)
                      ->first();

        if ($user && password_verify($password, $user['password'])) {
            $userModel = new \App\Models\UserModel();
            $signCheck = $userModel->getUserByUsername($user['username']);

            if (!$signCheck) {
                return redirect()->back()->with('error', 'Please fill the signup form first');
            }

            $session->set('username', $user['username']);

            return view('auth/success_redirect', [
                'redirectUrl' => base_url('dashboard'),
                'seconds' => 3
            ]);
        } else {
            return redirect()->back()->with('error', 'Invalid login credentials');
        }
    }

    // -------------------- DASHBOARD --------------------
    public function dashboard()
    {
        $username = session()->get('username');
        return view('auth/dashboard', ['username' => $username]);
    }

    // -------------------- LOGOUT --------------------
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/dashboard');
    }

    // -------------------- ORDERS --------------------
    public function orders()
    {
        if (!session()->get('username')) {
            return redirect()->to('/login')->with('error', 'Please login to view your orders');
        }

        $db = \Config\Database::connect();
        $username = session()->get('username');

        $orders = $db->table('order_manager')
            ->where('username', $username)
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();

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

    // -------------------- CHANGE PASSWORD --------------------
    public function changePasswordForm()
    {
        return view('auth/change_password');
    }

    public function verifyEmail()
    {
        $email = strtolower($this->request->getPost('email'));
        $model = new AuthModel();
        $user = $model->where('email', $email)->first();

        if ($user) {
            return $this->response->setJSON(['exists' => true]);
        } else {
            return $this->response->setJSON(['exists' => false]);
        }
    }

    public function updatePassword()
    {
        $email = strtolower($this->request->getPost('email'));
        $newPassword = $this->request->getPost('newPassword');

        $model = new AuthModel();
        $user = $model->where('email', $email)->first();

        if (!$user) {
            return $this->response->setJSON(['message' => 'User not found']);
        }

        if (strlen($newPassword) < 8) {
            return $this->response->setJSON(['message' => 'Password must be at least 8 characters']);
        }

        $model->update($user['id'], ['password' => password_hash($newPassword, PASSWORD_DEFAULT)]);

        return $this->response->setJSON(['message' => 'Password updated successfully ✅']);
    }
}
