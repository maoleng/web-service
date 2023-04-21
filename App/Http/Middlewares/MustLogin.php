<?php

namespace App\Http\Middlewares;

class MustLogin extends Middleware
{

    public function handle(): void
    {
        if (authed() === null) {
            redirect()->route('login');
        }
    }


}