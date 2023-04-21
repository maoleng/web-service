<?php

namespace App\Models;

use Libraries\database_drivers\Model;

class OrderProduct extends Model
{

    public string $table = 'orders_products';

    protected array $fillable = [
        'order_id', 'product_id', 'amount', 'price',
    ];

    protected array $not_string_attributes = [
        'amount', 'price',
    ];

}