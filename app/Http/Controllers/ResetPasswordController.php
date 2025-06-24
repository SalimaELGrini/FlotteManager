<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ResetPasswordController extends Controller
{
    // 1. Affichage formulaire d'email
    public function showEmailForm()
    {
        return view('auth.passwords.email'); // Vue d’email
    }

    // 2. Envoi du code à l'email
    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $code = rand(100000, 999999); // Génération du code
        session(['reset_code' => $code]);
        session(['reset_email' => $request->email]);

        // Simulation : affichage dans log (si mail désactivé)
        logger("Code de vérification pour {$request->email} est : $code");

        return redirect()->route('password.code.form')->with('success', 'Code envoyé à votre email');
    }

    // 3. Formulaire de vérification du code
    public function showCodeForm()
    {
        return view('auth.passwords.reset-code');
    }

    // 4. Vérification du code
    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        if ($request->code == session('reset_code')) {
            return redirect()->route('password.new');
        }

        return back()->withErrors(['code' => 'Code incorrect']);
    }

    // 5. Affichage du formulaire de nouveau mot de passe
    public function showNewPasswordForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.passwords.new-password');
    }

    // 6. Mise à jour du mot de passe
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::where('email', session('reset_email'))->first();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            Session::forget('reset_code');
            Session::forget('reset_email');

            return redirect('/login')->with('success', 'Mot de passe changé avec succès');
        }

        return back()->withErrors(['email' => 'Utilisateur non trouvé']);
    }
}
