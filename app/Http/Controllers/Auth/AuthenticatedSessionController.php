<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Enums\UserRole;
use App\Enums\UserStatut;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Affiche la page de connexion.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Gère la connexion de l'utilisateur.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // (Optionnel) Vérifie que le compte est actif
        // if ($user->statut !== UserStatut::ACTIF->value) {
        //     Auth::logout();
        //     return back()->withErrors([
        //         'email' => 'Votre compte n’est pas actif.',
        //     ]);
        // }

        // ✅ Redirection selon le rôle
        switch ($user->role) {
            case UserRole::ADMINISTRATEUR->value:
                return redirect()->intended('/filament/admin/pages/dashboard');
            case UserRole::PROPRIETAIRE->value:
                return redirect()->intended('/proprietaire/dashboard');
            case UserRole::CLIENT->value:
                return redirect()->intended('/client/dashboard');
            default:
                return redirect()->route('home');
        }
    }

    /**
     * Déconnexion de l'utilisateur.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
