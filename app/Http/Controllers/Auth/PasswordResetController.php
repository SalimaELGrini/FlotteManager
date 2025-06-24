<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;

class PasswordResetController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot');
    }

    public function sendResetCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'Email introuvable.');
        }

        $code = rand(100000, 999999);

        DB::table('password_reset_codes')->updateOrInsert(
            ['email' => $request->email],
            ['code' => $code, 'created_at' => Carbon::now()]
        );

        Mail::raw("Voici votre code de réinitialisation : $code", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Code de réinitialisation de mot de passe');
        });

        return redirect()->route('verify.code.form')->with('email', $request->email);
    }

    public function showVerifyForm()
    {
        return view('auth.verify_code');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required'
        ]);

        $record = DB::table('password_reset_codes')
            ->where('email', $request->email)
            ->where('code', $request->code)
            ->first();

        if (!$record) {
            return back()->withErrors(['code' => 'Code incorrect.']);
        }

        return redirect()->route('password.reset.form')->with('email', $request->email);
    }

    public function showResetForm()
    {
        return view('auth.reset');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        DB::table('password_reset_codes')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Mot de passe réinitialisé avec succès.');
    }
}

