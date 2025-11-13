<?php

namespace App\Http\Controllers;

use App\Models\BienImmobilier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AccueilController extends Controller
{
    /**
     * Affiche la page d'accueil
     */
    public function index()
    {
        try {
            // Vérifier si la table existe
            if (!Schema::hasTable('biens_immobiliers')) {
                return view('accueil', ['biensVedettes' => collect()]);
            }

            // Biens en vedette pour la page d'accueil
            $biensVedettes = BienImmobilier::with('illustrations')
                ->where('statut', 'DISPONIBLE')
                ->orderBy('created_at', 'desc')
                ->limit(6)
                ->get();

            // Si pas de biens disponibles, prendre les derniers biens
            if ($biensVedettes->isEmpty()) {
                $biensVedettes = BienImmobilier::with('illustrations')
                    ->orderBy('created_at', 'desc')
                    ->limit(6)
                    ->get();
            }

            return view('accueil', compact('biensVedettes'));

        } catch (\Exception $e) {
            // En cas d'erreur, retourner une vue vide
            return view('accueil', ['biensVedettes' => collect()]);
        }
    }

    /**
     * Affiche la page "À propos"
     */
    public function aPropos()
    {
        return view('a-propos');
    }

    /**
     * Affiche la page de contact
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Traite le formulaire de contact
     */
    public function envoyerMessage(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'sujet' => 'required|string|max:255',
            'message' => 'required|string|min:10'
        ]);

        return redirect()->route('contact')
            ->with('success', 'Votre message a été envoyé avec succès !');
    }
}
