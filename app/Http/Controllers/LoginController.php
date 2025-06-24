<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Affichage de la page de login
    public function show()
    {
        return view('auth.login');
    }

    // Authentification de l'utilisateur
    public function login(Request $request)
    {
        // Validation des données
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tentative de connexion
        if (Auth::attempt($credentials)) {
            // Régénérer la session (sécurité)
            $request->session()->regenerate();

            // Vérifier le statut de l'utilisateur
            $user = Auth::user();

            // Superadmin   
            if ($user->id != 1 && $user->status !== 'Approuvé') {
                Auth::logout();
                return redirect('/login')->withErrors([
                    'email' => 'Votre compte est en attente d\'approbation.',
                ]);
            }

            // Redirection selon le rôle
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard'); // superadmin
            } elseif ($user->role === 'user') {
                return redirect('/user/dashboard'); // admin
            } else {
                // Au cas où c'est un rôle inconnu ou autre
                Auth::logout();
                return redirect('/login')->withErrors(['email' => 'Rôle utilisateur non autorisé.']);
            }
        }

        // Si échec de connexion
        return back()->withErrors([
            'email' => 'Les informations d\'identification ne correspondent pas.',
        ]);
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}


