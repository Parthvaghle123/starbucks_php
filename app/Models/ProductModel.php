<?php
namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'price', 'image', 'category', 'page', 'status', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
