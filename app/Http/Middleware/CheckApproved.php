<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckApproved
{
    public function handle($request, Closure $next)
{
    $user = Auth::user();

    // Si l'utilisateur est connecté
    if ($user) {

        //  Exception pour superadmin (ID = 1)
        if ($user->id == 1) {
            return $next($request);
        }

        //  Si ce n'est pas superadmin et qu'il n'est pas approuvé
        if ($user->status !== 'Approuvé') {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Votre compte est en attente d\'approbation.',
            ]);
        }
    }

    return $next($request);
}


}
