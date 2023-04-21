<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;

class CartController extends Controller
{

    public function index(): void
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
        $cart = (new OrderProduct)->raw("
            SELECT product_id, products.name, image,
                   orders_products.price, amount, (products.price * amount) as `sum`
            FROM orders_products
            LEFT JOIN products ON products.id = orders_products.product_id
            WHERE order_id = $order->id
        ");

        $data = [];
        $total = 0;
        foreach ($cart as $each) {
            $total += $each->amount * $each->price;
            $data[] = [
                'product_id' => $each->product_id,
                'name' => $each->name,
                'price' => prettyMoney($each->price),
                'amount' => $each->amount,
                'sum' => prettyMoney($each->sum),
            ];
        }

        response()->json([
            'status' => true,
            'data' => [
                'total' => $total,
                'cart' => $data,
            ],
        ]);
    }

}