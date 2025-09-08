<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'order_manager';
    protected $primaryKey = 'id';  // ✅ Correct column name per your table
    protected $allowedFields = [
        'Email', 'Phone', 'Address', 'Pay_Mode', 'username',
        'Card_Number', 'CVV', 'Card_Expiry', 'Date', 'Status'
    ];
    
}
