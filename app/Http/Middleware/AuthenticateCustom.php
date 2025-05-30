<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class AuthenticateCustom extends Middleware
{
        protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            if ($request->is('restaurant/*')) {
                return route('login.restaurant');
            }

            if ($request->is('user/*')) {
                return route('login.user');
            }
        }

        return null;
    }
}
