<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Gère l'accès aux routes selon le rôle de l'utilisateur.
     *
     * Exemple d’utilisation :
     * Route::middleware(['auth', 'role:proprietaire'])->group(...);
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Si l'utilisateur n'est pas connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter.');
        }

        $user = Auth::user();

        // Vérifie le rôle (depuis ton enum App\Enums\UserRole)
        if ($user->role->value !== $role) {
            // Redirection selon le rôle réel
            return match ($user->role->value) {
                'administrateur' => redirect('/admin'),
                'proprietaire'   => redirect('/proprietaire/dashboard'),
                'client'         => redirect('/client/dashboard'),
                default          => redirect()->route('home'),
            };
        }

        
        return $next($request);
    }
}
