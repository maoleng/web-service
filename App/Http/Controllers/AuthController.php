<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;

class AuthController extends Controller
{

    public function login()
    {
        return view('customer.auth.login');
    }

    public function register()
    {
        return view('customer.auth.register');
    }

    public function processLogin(LoginRequest $request): void
    {
        $data = $request->validated();
        $user = (new User)->where('email', $data['email'])->first();
        if ($user === null) {
            redirectBackWithError('Wrong email address or password');
        }
        if (! $user->verify($data['password'])) {
            redirectBackWithError('Wrong email address or password');
        }
        session()->put('auth', $user);

        redirect()->route('/');
    }

    public function processRegister(RegisterRequest $request): void
    {
        $data = $request->validated();
        $user = (new User)->where('email', $data['email'])->first();
        if ($user !== null) {
            redirectBackWithError('Email already exists');
        }
        (new User())->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'is_admin' => 0,
            'created_at' => now()->format('Y-m-d H:i:s'),
        ]);
        session()->flash('success', 'Registered successfully');

        redirect()->route('/');
    }

    public function logout(): void
    {
        session()->forget('auth');

        redirect()->route('/');
    }




}