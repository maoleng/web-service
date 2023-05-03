<?php

namespace App\Models;

use Libraries\database_drivers\Model;

class Product extends Model
{

    public string $table = 'products';

    protected array $fillable = [
        'name', 'description', 'price', 'image', 'created_at',
    ];

    protected array $not_string_attributes = [
        'price',
    ];

}