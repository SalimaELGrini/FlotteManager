<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    
    

public function handle($request, Closure $next)
{
    if (Auth::check() && Auth::user()->role !== 'admin') {
        return redirect('/')->with('error', 'Accès réservé au admin.');
    }

    return $next($request);
}

}
