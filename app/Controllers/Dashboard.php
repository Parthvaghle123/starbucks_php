<?php
namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        // ✅ Session check
        if (!session()->get('AdminLoginId')) {
            return redirect()->to('/login');
        }

        return view('dashboard/index'); // ✅ view file: app/Views/dashboard/index.php
    }
}
