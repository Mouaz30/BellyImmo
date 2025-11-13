<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Affiche la page d'inscription.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Gère l'inscription d'un nouvel utilisateur.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validation des champs
        $request->validate([
            'prenom' => ['required', 'string', 'max:255'],
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,NULL,id,deleted_at,NULL'],
            'role' => ['required', 'in:client,proprietaire'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Pour le moment, tous les comptes sont actifs
        $statut = 'actif';

        // Création de l'utilisateur
        $user = User::create([
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'email' => $request->email,
            'role' => $request->role,
            'statut' => $statut,
            'password' => Hash::make($request->password),
        ]);

        // Déclenchement de l'événement Registered
        event(new Registered($user));

        // Connexion automatique après inscription
        Auth::login($user);

        // Redirection selon le rôle
        if ($user->role === 'client') {
            return redirect(RouteServiceProvider::HOME)
                ->with('success', 'Inscription réussie ! Bienvenue sur votre espace client.');
        } elseif ($user->role === 'proprietaire') {
            return redirect()->intended('/proprietaire')
                ->with('success', 'Inscription réussie ! Bienvenue sur votre espace propriétaire.');
        }

        return redirect()->route('home');
    }
}
