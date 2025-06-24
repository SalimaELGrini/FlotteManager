<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;

class UserMiddleware
{
   
        public function handle($request, Closure $next)
        {
            if (Auth::check() && Auth::user()->role !== 'user') {
                return redirect('/')->with('error', 'Accès réservé aux utilisateurs.');
            }
    
            return $next($request);
        }
    
}
