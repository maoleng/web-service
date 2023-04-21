<?php

namespace App\Http\Middlewares;

use App\Models\User;

abstract class Middleware
{

    public function identify()
    {
        $bearer_token = getRequestHeader('Authorization');
        if (empty($bearer_token)) {
            $this->throwUnauthorized();
        }
        $token = substr($bearer_token, 7);
        $user = (new User)->where('token', $token)->first();
        if ($user === null) {
            $this->throwUnauthorized();
        }

        $_SESSION['user'] = $user;

        return $user;
    }

    public function throwUnauthorized(): void
    {
        response()->json([
            'status' => false,
            'data' => [
                'message' => 'You must be logged in first',
            ],
        ]);
    }

    abstract public function handle();
}