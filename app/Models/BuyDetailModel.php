<?php

namespace App\Models;

use CodeIgniter\Model;

class BuyDetailModel extends Model
{
    protected $table = 'buy_detail';
    protected $allowedFields = [
        'buy_id', 'komik_id', 'amount',
        'price', 'discount', 'total_price'
    ];
}
