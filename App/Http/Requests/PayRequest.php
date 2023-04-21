<?php

namespace App\Http\Requests;

use App\Models\Product;
use Libraries\Request\Form\FormRequest;

class PayRequest extends FormRequest
{

    public function rules()
    {
        return [
            'address' => function ($value) {
                if ($value === null) {
                    return $this->fail('Address must not be empty');
                }
            },
            'phone' => function ($value) {
                if ($value === null) {
                    return $this->fail('Phone must not be empty');
                }
            },
            'bank_code' => function ($value) {
                if (! in_array($value, ['VNPAYQR', 'VNBANK', 'INTCARD'])) {
                    return $this->fail('Bank Code is only 1 of VNPAYQR, VNBANK, INTCARD');
                }
            },
        ];
    }


}