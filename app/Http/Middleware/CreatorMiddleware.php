<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreatorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login first.');
        }

        // Check if user has creator role
        if (Auth::user()->role !== 'creator') {
            return redirect('/login')->with('error', 'Access denied. Creator role required.');
        }

        return $next($request);
    }
}
