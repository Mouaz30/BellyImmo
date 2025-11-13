<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Affiche la liste des utilisateurs
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filtres de recherche
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->search . '%')
                    ->orWhere('prenom', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        if ($request->has('statut') && $request->statut) {
            $query->where('statut', $request->statut);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('users.index', compact('users'));
    }

    /**
     * Affiche le formulaire de création d'utilisateur
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Enregistre un nouvel utilisateur
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'telephone' => 'nullable|string|max:20',
            'role' => 'required|in:client,proprietaire,admin',
            'statut' => 'required|in:actif,inactif,suspendu',
        ]);

        User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telephone' => $request->telephone,
            'role' => $request->role,
            'statut' => $request->statut,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur créé avec succès !');
    }

    /**
     * Affiche les détails d'un utilisateur
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Affiche le formulaire d'édition d'utilisateur
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Met à jour un utilisateur
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'telephone' => 'nullable|string|max:20',
            'role' => 'required|in:client,proprietaire,admin',
            'statut' => 'required|in:actif,inactif,suspendu',
        ]);

        $data = [
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'role' => $request->role,
            'statut' => $request->statut,
        ];

        // Mettre à jour le mot de passe seulement si fourni
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur mis à jour avec succès !');
    }

    /**
     * Supprime un utilisateur (soft delete)
     */
    public function destroy(User $user)
    {
        // Empêcher la suppression de son propre compte
        if ($user->id === auth()->id()) {
            return redirect()->back()
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte !');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur supprimé avec succès !');
    }

    /**
     * Affiche les utilisateurs supprimés
     */
    public function trashed()
    {
        $users = User::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(15);
        return view('users.trashed', compact('users'));
    }

    /**
     * Restaure un utilisateur supprimé
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.trashed')
            ->with('success', 'Utilisateur restauré avec succès !');
    }

    /**
     * Supprime définitivement un utilisateur
     */
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();

        return redirect()->route('users.trashed')
            ->with('success', 'Utilisateur supprimé définitivement !');
    }

    /**
     * Met à jour le profil de l'utilisateur connecté
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'telephone' => 'nullable|string|max:20',
        ]);

        $user->update($request->only(['nom', 'prenom', 'email', 'telephone']));

        return redirect()->back()->with('success', 'Profil mis à jour avec succès !');
    }

    /**
     * Change le mot de passe de l'utilisateur connecté
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Mot de passe modifié avec succès !');
    }

    /**
     * Active/désactive un utilisateur
     */
    public function toggleStatus(User $user)
    {
        $user->update([
            'statut' => $user->statut === 'actif' ? 'inactif' : 'actif'
        ]);

        $action = $user->statut === 'actif' ? 'activé' : 'désactivé';

        return redirect()->back()->with('success', "Utilisateur {$action} avec succès !");
    }
}
