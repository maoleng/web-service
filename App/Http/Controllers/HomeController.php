<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{

    public function index(): void
    {
        response()->json([
            'status' => true,
            'message' => 'Welcome to Our Report',
            'valid_apis' => [
                'auth' => [
                    'register' => [
                        'description' => 'User register an account',
                        'path' => '/register',
                        'method' => 'POST',
                        'body_json' => [
                            'name' => 'string',
                            'email' => 'string',
                            'password' => 'string',
                        ],
                    ],
                    'login' => [
                        'description' => 'User Login',
                        'path' => '/login',
                        'method' => 'POST',
                        'body_json' => [
                            'email' => 'string',
                            'password' => 'string',
                        ],
                    ],
                ],
                'product' => [
                    'get_products' => [
                        'description' => 'Get all products with pagination',
                        'path' => '/product',
                        'method' => 'GET',
                        'query_params' => [
                            'page' => 'int',
                        ],
                    ],
                    'show_product' => [
                        'description' => 'Show information about a product',
                        'path' => '/product/{id}',
                        'method' => 'GET',
                    ],
                    'store_product' => [
                        'description' => 'Create a product',
                        'path' => '/product',
                        'method' => 'POST',
                        'headers' => [
                            'Authorization' => 'Bearer {token}',
                        ],
                        'body_json' => [
                            'name' => 'string',
                            'description' => 'string',
                            'price' => 'string',
                            'image' => 'string',
                        ],
                    ],
                    'update_product' => [
                        'description' => 'Update a product by id',
                        'path' => '/product/{id}',
                        'method' => 'PUT',
                        'headers' => [
                            'Authorization' => 'Bearer {token}',
                        ],
                        'body_json' => [
                            'name' => 'string',
                            'description' => 'string',
                            'price' => 'string',
                            'image' => 'string',
                        ],
                    ],
                    'destroy_product' => [
                        'description' => 'Delete a product by id',
                        'path' => '/product/{id}',
                        'method' => 'DELETE',
                        'headers' => [
                            'Authorization' => 'Bearer {token}',
                        ],
                    ],
                ],
                'cart' => [
                    'get_cart' => [
                        'description' => 'Get a cart include products with its amount and price',
                        'path' => '/cart',
                        'method' => 'GET',
                        'headers' => [
                            'Authorization' => 'Bearer {token}',
                        ],
                    ],
                    'update_cart' => [
                        'description' => 'Add product to cart, remove product from cart, change the product amount',
                        'path' => '/cart',
                        'method' => 'PUT',
                        'headers' => [
                            'Authorization' => 'Bearer {token}',
                        ],
                        'body_json' => [
                            'product_id' => 'int',
                            'amount' => 'int',
                        ],
                    ],
                ],
                'pay' => [
                    'get_payment_url' => [
                        'description' => 'Get the payment url',
                        'path' => '/pay',
                        'method' => 'POST',
                        'headers' => [
                            'Authorization' => 'Bearer {token}',
                        ],
                        'body_json' => [
                            'address' => 'string',
                            'phone' => 'string',
                            'bank_code' => 'string',
                        ],
                    ],
                    'verify_payment' => [
                        'description' => 'Verify the payment, this is called by VNPAY',
                        'path' => '/pay/verify',
                        'method' => 'GET',
                    ],
                ],
                'order' => [
                    'get_orders' => [
                        'description' => 'Get all orders with pagination',
                        'path' => '/order',
                        'method' => 'GET',
                        'headers' => [
                            'Authorization' => 'Bearer {token}',
                        ],
                        'query_params' => [
                            'page' => 'int',
                        ],
                    ],
                    'show_order' => [
                        'description' => 'Show information about an order',
                        'path' => '/order/{id}',
                        'method' => 'GET',
                        'headers' => [
                            'Authorization' => 'Bearer {token}',
                        ],
                    ],
                ]
            ]
        ]);
    }

}