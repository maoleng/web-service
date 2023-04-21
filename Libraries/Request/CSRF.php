<?php

namespace Libraries\Request;

use Illuminate\Support\Str;

trait CSRF
{
    private function generateToken(): string
    {
        return bin2hex(Str::random(50));
    }

    private function validateCsrf(): void
    {
        if ($this->method === 'GET') {
            if (session()->exists('_token') === false) {
                session()->put('_token', $this->generateToken());
            }
        } else {
            $token = $this->input('_token');
            if (empty($token) || $token !== session()->get('_token')) {
                throwHttpException('CSRF token is invalid');
            }
            session()->forget('_token');
        }
    }

}