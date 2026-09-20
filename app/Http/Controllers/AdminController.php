<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Stagiaire;
use App\Models\DemandeStage;
use App\Models\Presence;
use App\Models\AppNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers       = User::count();
        $totalStagiaires  = Stagiaire::count();
        $totalDemandes    = DemandeStage::count();
        $demandesValidees = DemandeStage::validee()->count();
        $demandesRefusees = DemandeStage::refusee()->count();
        $demandesAttente  = DemandeStage::enAttente()->count();

        $totalPresences  = Presence::count();
        $totalPresentss  = Presence::where('present', true)->count();
        $attendanceRate  = $totalPresences > 0 ? round(($totalPresentss / $totalPresences) * 100, 2) : 0;

        $presencesData = Stagiaire::with('presences')->get()->map(function ($s) {
            $total    = $s->presences->count();
            $presents = $s->presences->where('present', true)->count();
            return [
                'nom'  => $s->prenom . ' ' . $s->nom,
                'rate' => $total > 0 ? round(($presents / $total) * 100, 2) : 0,
            ];
        });

        $resetRequests = AppNotification::where('user_id', auth()->id())
            ->where('titre', 'like', '%réinitialisation%')
            ->where('lu', false)
            ->latest()
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalStagiaires', 'totalDemandes',
            'demandesValidees', 'demandesRefusees', 'demandesAttente',
            'attendanceRate', 'presencesData', 'resetRequests'
        ));
    }

    public function users()
    {
        $users = User::orderBy('role')->orderBy('nom')->get();

        $resetRequests = AppNotification::where('user_id', auth()->id())
            ->where('titre', 'like', '%réinitialisation%')
            ->where('lu', false)
            ->latest()
            ->get();

        return view('admin.utilisateurs.index', compact('users', 'resetRequests'));
    }

    public function resetPassword(User $user)
    {
        $tempPassword = Str::random(8);
        $user->update(['password' => Hash::make($tempPassword)]);

        // Sync le mot de passe dans la table stagiaires si applicable
        if ($user->role === 'stagiaire' && $user->email) {
            Stagiaire::where('email', $user->email)
                ->update(['password' => Hash::make($tempPassword)]);
        }

        // Marquer les notifications de demande comme lues pour cet utilisateur
        AppNotification::where('user_id', auth()->id())
            ->where('titre', 'like', '%réinitialisation%')
            ->where('message', 'like', "%{$user->nom}%")
            ->update(['lu' => true]);

        return back()->with([
            'reset_user'    => $user->nom . ' (' . $user->matricule . ')',
            'temp_password' => $tempPassword,
            'user_phone'    => $user->role === 'stagiaire'
                ? optional(Stagiaire::where('email', $user->email)->first())->telephone
                : '692739565',
        ]);
    }
}
