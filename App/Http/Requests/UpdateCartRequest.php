<?php

namespace App\Http\Requests;

use App\Models\Product;
use Libraries\Request\Form\FormRequest;

class UpdateCartRequest extends FormRequest
{

    public function rules()
    {
        return [
            'product_id' => function ($value) {
                if ($value === null) {
                    return $this->fail('Product ID must not be empty');
                }
                $product = (new Product)->find($value);
                if ($product === null) {
                    return $this->fail('Product is not found');
                }
                $this->merge(['product' => $product]);
            },
            'amount' => function ($value) {
                if ($value === null || $value < 0) {
                    return $this->fail('Amount is invalid');
                }
            },
        ];
    }


}