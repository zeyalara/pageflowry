<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login first.');
        }

        // Check if user has admin role
        if (Auth::user()->role !== 'admin') {
            return redirect('/login')->with('error', 'Access denied. Admin role required.');
        }

        return $next($request);
    }
}
