<?php

namespace App\Http\Requests\Auth;

use Libraries\Request\Form\FormRequest;

class LoginRequest extends FormRequest
{

    public function rules()
    {
        return [
            'email' => function ($value) {
                if ($value === '') {
                    return $this->fail('Email must not be empty');
                }
            },
            'password' => function ($value) {
                if ($value === '') {
                    return $this->fail('Password must not be empty');
                }
            }
        ];
    }


}