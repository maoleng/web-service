<?php

namespace App\Http\Requests;

use Libraries\Request\Form\FormRequest;

class UpdateProfileRequest extends FormRequest
{

    public function rules()
    {
        $is_change_password = $this->get('is_change_password') === 'on';

        return [
            'name' => function ($value) {
                if ($value === '') {
                    return $this->fail('Name must not be empty');
                }
            },
            'password' => function ($value) use ($is_change_password) {
                if ($value === '' && $is_change_password) {
                    return $this->fail('Password must not be empty');
                }
            },
            'new_password' => function ($value) use ($is_change_password) {
                if ($value === '' && $is_change_password) {
                    return $this->fail('New password must not be empty');
                }
            },
            're_password' => function ($value) use ($is_change_password) {
                if ($value === '' && $is_change_password) {
                    return $this->fail('Retype password must not be empty');
                }
                if ($this->get('new_password') !== $this->get('re_password')) {
                    return $this->fail('New password and retype password is not match');
                }
            },
        ];
    }


}