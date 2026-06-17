<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'password'   => 'required|string',
        ], [
            'identifier.required' => 'Veuillez entrer votre matricule ou email.',
            'password.required'   => 'Veuillez entrer votre mot de passe.',
        ]);

        $identifier = $request->input('identifier');
        $password   = $request->input('password');

        $field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'matricule';

        if (Auth::attempt([$field => $identifier, 'password' => $password], $request->boolean('remember'))) {
            $request->session()->regenerate();

            return match (Auth::user()->role) {
                'admin'     => redirect()->route('admin.dashboard'),
                'encadrant' => redirect()->route('encadrant.dashboard'),
                'stagiaire' => redirect()->route('stagiaire.dashboard'),
                default     => redirect('/'),
            };
        }

        return back()->withErrors(['identifier' => 'Identifiant ou mot de passe incorrect.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
