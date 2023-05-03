<?php

namespace App\Http\Requests\Auth;

use Libraries\Request\Form\FormRequest;

class RegisterRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => function ($value) {
                if ($value === null) {
                    return $this->fail('Name must not be empty');
                }
            },
            'email' => function ($value) {
                if ($value === null) {
                    return $this->fail('Email must not be empty');
                }
            },
            'password' => function ($value) {
                if ($value === null) {
                    return $this->fail('Password must not be empty');
                }
            },

        ];
    }


}