<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {

            // Admin guard
            if ($request->is('admin/*')) {
                return route('admin.login');
            }

            // Default user guard (renter/manager)
            return route('login');
        }
    }
}
