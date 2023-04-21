<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Exception;
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
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => prettyMoney($product->price),
                    'image' => $product->image,
                    'created_at' => $product->created_at,
                ],
            ],
        ]);
    }

    public function update(ProductRequest $request, $id): void
    {
        $data = $request->validated();

        $product = (new Product)->findOrFail($id);
        foreach ($data as $column => $value) {
            $product->$column = $value;
        }
        $product->save();

        response()->json([
            'status' => true,
            'data' => [
                'message' => 'Updated product successfully',
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => prettyMoney($product->price),
                    'image' => $product->image,
                    'created_at' => $product->created_at,
                ],
            ],
        ]);
    }

    public function destroy(Request $request, $id): void
    {
        $product = (new Product)->findOrFail($id);
        try {
            $product->delete();
        } catch (Exception) {
            response()->json([
                'status' => false,
                'data' => [
                    'message' => 'Can not delete product because it is already in user\'s order',
                ],
            ]);
        }

        response()->json([
            'status' => true,
            'data' => [
                'message' => 'Delete product successfully',
            ],
        ]);
    }

}