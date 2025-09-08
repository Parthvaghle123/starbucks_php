<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function gift()
    {
        return view('auth/gift');  // Correct path to gift.php inside Views/auth/
    }
}
