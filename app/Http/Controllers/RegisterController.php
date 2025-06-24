<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\UserRegistered;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'username' => 'required|string|max:255|min:2',
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'password' => 'required|string|min:5|max:255',
            'role' => 'required|in:user,admin',
        ], [
            'username.required' => 'Le nom d\'utilisateur est obligatoire.',
            'username.min' => 'Le nom d\'utilisateur doit contenir au moins 2 caractères.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'email.regex' => 'Le format de l\'email est invalide.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 5 caractères.',
            'role.required' => 'Le rôle est obligatoire.',
            'role.in' => 'Le rôle doit être soit user soit admin.',
        ]);
        

        $user = User::create([
            'username' => $attributes['username'],
            'email' => $attributes['email'],
            'password' => bcrypt($attributes['password']),
            'role' => $attributes['role'],
            'status' => 'En attente',
        ]);

        // Notification uniquement au superadmin
        $superadmin = User::find(1);
        if ($superadmin && $user->id !== 1) {
            $superadmin->notify(new UserRegistered($user));
        }

        if ($user->status === 'Approuvé') {
            auth()->login($user);

            return $user->role === 'admin'
                ? redirect('/admin/dashboard')
                : redirect('/dashboard');
        } else {
            return redirect('/login')->withErrors([
                'email' => 'Votre compte est en attente d\'approbation.',
            ]);
        }
    }

}


