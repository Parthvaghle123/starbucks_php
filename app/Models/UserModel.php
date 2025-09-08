<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'sign';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'phone', 'gender', 'dob', 'age', 'address'];

    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}
