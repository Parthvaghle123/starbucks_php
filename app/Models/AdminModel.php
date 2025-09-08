<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'password'];

    public function isAdminExists($username)
    {
        return $this->where('username', $username)->orWhere('email', $username)->first();
    }

    public function getAdminCount()
    {
        return $this->countAllResults();
    }
}