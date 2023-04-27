<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use Libraries\Request\Request;

class OrderController extends Controller
{

    public function index(): void
    {
        $orders = (new Order)->where('user_id', authed()->id)->orderByDesc('created_at')->paginate();
        $data = [];
        foreach ($orders['data'] as $order) {
            $data[] = [
                'id' => $order->id,
                'total' => prettyMoney($order->total),
                'status' => $order->status,
                'address' => $order->address,
                'phone' => $order->phone,
                'bank_code' => $order->bank_code,
                'transaction_code' => $order->transaction_code,
                'created_at' => $order->created_at,
            ];
        }

        response()->json([
            'status' => true,
            'data' => $data,
            'meta' => $orders['meta'],
        ]);
    }

    public function show(Request $request, $id)
    {
        $order = (new Order)->where('user_id', authed()->id)->findOrFail($id);
        $order_product = (new OrderProduct)->raw("
            SELECT product_id, products.name, image,
                   orders_products.price, amount, (products.price * amount) as `sum`
            FROM orders_products
            LEFT JOIN products ON products.id = orders_products.product_id
            WHERE order_id = $id
        ");

        $data = [];
        foreach ($order_product as $each) {
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
                'total' => $order->total,
                'order' => $data,
            ],
        ]);
    }
}