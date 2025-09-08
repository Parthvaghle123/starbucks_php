<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = 'login';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'password', 'created_at'];

    public function isUsernameExists($username)
    {
        return $this->where('username', $username)->first();
    }

    public function insertSignDetails($data)
    {
        $db = \Config\Database::connect();
        return $db->table('sign')->insert($data);
    }
}
