<?php

namespace App\Http\Requests;

use Libraries\Request\Form\FormRequest;

class ProductRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => function ($value) {
                if ($value === null) {
                    return $this->fail('Name must not be empty');
                }
            },
            'description' => function ($value) {
                if ($value === null) {
                    return $this->fail('Description must not be empty');
                }
            },
            'price' => function ($value) {
                if ($value === null) {
                    return $this->fail('Price must not be empty');
                }
            },
            'image' => function ($value) {
                if ($value === null) {
                    return $this->fail('Image must not be empty');
                }
            },
        ];
    }


}