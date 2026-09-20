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

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function submitForgotPassword(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
        ], [
            'identifier.required' => 'Veuillez saisir votre adresse email ou votre matricule.',
        ]);

        $identifier = trim($request->input('identifier'));

        $user = \App\Models\User::where('email', $identifier)
            ->orWhere('matricule', $identifier)
            ->first();

        if ($user) {
            // Notify Admins
            $admins = \App\Models\User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                \App\Models\AppNotification::create([
                    'user_id' => $admin->id,
                    'titre'   => 'Demande de réinitialisation mdp',
                    'message' => "L'utilisateur {$user->nom} (Matricule: {$user->matricule}, Email: {$user->email}) a demandé la réinitialisation de son mot de passe.",
                    'type'    => 'warning',
                    'lien'    => route('admin.users.index'),
                ]);
            }

            $waText = urlencode("Bonjour Administrateur, je sollicite la réinitialisation du mot de passe pour mon compte Suivi Stagiaires : {$user->nom} (Matricule: {$user->matricule}, Email: {$user->email}).");
            $waUrl  = "https://wa.me/237692739565?text={$waText}";

            return back()->with([
                'success'        => 'Votre demande de réinitialisation a été enregistrée et transmise à l\'administrateur.',
                'user_found'     => $user->nom,
                'whatsapp_link'  => $waUrl,
            ]);
        }

        return back()->with('error', 'Aucun compte trouvé correspondant à cet identifiant (Email ou Matricule). Vérifiez vos informations ou contactez l\'administration.');
    }
}
