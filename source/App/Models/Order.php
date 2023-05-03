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

    public static function getCart(): Order
    {
        $order = (new Order)->where('user_id', authed()->id)->where('status', 'In cart')->first();
        if ($order === null) {
            $order = (new Order)->create([
                'total' => 0,
                'status' => 'In cart',
                'address' => '',
                'phone' => '',
                'bank_code' => '',
                'transaction_code' => '',
                'user_id' => authed()->id,
                'created_at' => now()->toDateTimeString(),
            ]);
        }

        return $order;
    }
}