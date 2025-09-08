<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table = 'user_order';
    protected $primaryKey = 'id';
    protected $allowedFields = ['order_id', 'Item_Name', 'Price', 'Quantity', 'Status'];
}
