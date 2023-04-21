<?php

namespace App\Http\Middlewares;

class CustomerAuthenticate extends Middleware
{

    public function handle(): void
    {
        $this->identify();
        if (authed()->is_admin) {
            response()->json([
                'status' => false,
                'data' => [
                    'message' => 'You must be customer',
                ],
            ]);
        }
    }

}