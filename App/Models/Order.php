<?php

namespace App\Models;

use Libraries\database_drivers\Model;

class Order extends Model
{

    public string $table = 'orders';

    protected array $fillable = [
        'total', 'status', 'address', 'phone', 'bank_code', 'transaction_code', 'user_id', 'created_at',
    ];

    protected array $not_string_attributes = [
        'total',
    ];

}