<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCartRequest;
use App\Models\Order;
use App\Models\OrderProduct;

class CartController extends Controller
{

    public function index(): void
    {
        $order = Order::getCart();
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

    public function update(UpdateCartRequest $request): void
    {
        $data = $request->validated();
        $order = Order::getCart();

        $builder = (new OrderProduct)->where('order_id', $order->id)->where('product_id', $data['product_id']);

        if ($data['amount'] === 0) {
            $builder->delete();
        } else {
            $order_product = $builder->first();
            if ($order_product === null) {
                (new OrderProduct)->create([
                    'order_id' => $order->id,
                    'product_id' => $data['product_id'],
                    'amount' => $data['amount'],
                    'price' => $data['product']->price,
                ]);
            } else {
                $builder->update(['amount' => $data['amount']]);
            }
        }
        $total = (new OrderProduct)->raw("
            SELECT SUM(price * amount) AS `total` FROM orders_products WHERE order_id = $order->id 
        ")[0]->total;
        $order->update(['total' => $total]);

        response()->json([
            'status' => true,
            'data' => [
                'message' => 'Update cart successfully',
            ],
        ]);
    }

}