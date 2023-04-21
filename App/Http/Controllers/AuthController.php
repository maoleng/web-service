<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Lib\JWT\JWT;
use App\Models\User;

class AuthController extends Controller
{

    public function login(LoginRequest $request): void
    {
        $data = $request->validated();
        $user = (new User)->where('email', $data['email'])->first();
        if ($user === null) {
            response()->json([
                'status' => false,
                'data' => [
                    'message' => 'Wrong email address or password',
                ],
            ]);
        }
        if (! $user->verify($data['password'])) {
            response()->json([
                'status' => false,
                'data' => [
                    'message' => 'Wrong email address or password',
                ],
            ]);
        }
        $token = $this->generateUserToken($user);
        $user->update(['token' => $token]);

        response()->json([
            'status' => true,
            'data' => [
                'message' => 'Login successfully',
                'user' => [
                    'id' => (int) $user->attributes['id'],
                    'name' => $user->attributes['name'],
                    'email' => $user->attributes['email'],
                    'is_admin' => (bool) (int) $user->attributes['is_admin'],
                    'created_at' => $user->attributes['created_at'],
                ],
                'token' => $token,
            ],
        ]);
    }

    public function register(RegisterRequest $request): void
    {
        $data = $request->validated();
        $user = (new User)->where('email', $data['email'])->first();
        if ($user !== null) {
            response()->json([
                'status' => false,
                'data' => [
                    'message' => 'Email is already registered by another user',
                ],
            ]);
        }
        (new User())->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'is_admin' => 0,
            'token' => '',
            'created_at' => now()->format('Y-m-d H:i:s'),
        ]);

        response()->json([
            'status' => true,
            'data' => [
                'message' => 'Registered successfully',
            ],
        ]);
    }

    private function generateUserToken($user)
    {
        $user = (array) $user->attributes;
        unset($user['password'], $user['token']);

        return JWT::encode($user);
    }

}