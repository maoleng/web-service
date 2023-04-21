<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Libraries\Request\Request;

class ProductController extends Controller
{

    public function index(): void
    {
        $products = (new Product)->paginate();
        $data = [];
        foreach ($products['data'] as $product) {
            $data[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => prettyMoney($product->price),
                'image' => $product->image,
                'created_at' => $product->created_at,
            ];
        }

        response()->json([
            'status' => true,
            'data' => $data,
            'meta' => $products['meta'],
        ]);
    }

    public function show(Request $request, $id): void
    {
        $product = (new Product)->findOrFail($id);

        response()->json([
            'status' => true,
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => prettyMoney($product->price),
                'image' => $product->image,
                'created_at' => $product->created_at,
            ],
        ]);
    }

    public function store(ProductRequest $request): void
    {
        $data = $request->validated();
        $data['created_at'] = now()->toDateTimeString();

        $product = (new Product)->create($data);

        response()->json([
            'status' => true,
            'data' => [
                'message' => 'Created product successfully',
                'id' => $product->id,
            ],
        ]);
    }

}