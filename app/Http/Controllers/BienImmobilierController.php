<?php

namespace App\Http\Controllers;

use App\Models\BienImmobilier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class BienImmobilierController extends Controller
{
    /**
     * Affiche la liste de tous les biens
     */
    public function index(Request $request)
    {
        // Vérifier si la table existe
        if (!Schema::hasTable('biens_immobiliers')) {
            return view('biens.index', ['biens' => collect()]);
        }

        $query = BienImmobilier::with('illustrations', 'proprietaire')
            ->where('statut', 'DISPONIBLE'); // MAJUSCULES

        // Filtres de recherche
        if ($request->has('ville') && $request->ville) {
            $query->where('ville', 'like', '%' . $request->ville . '%');
        }

        if ($request->has('prix_min') && $request->prix_min) {
            $query->where('prix', '>=', $request->prix_min);
        }

        if ($request->has('prix_max') && $request->prix_max) {
            $query->where('prix', '<=', $request->prix_max);
        }

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        $biens = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('biens.index', compact('biens'));
    }

    /**
     * Affiche les détails d'un bien
     */
    public function show($id)
    {
        $bien = BienImmobilier::with(['illustrations', 'proprietaire'])
            ->findOrFail($id);

        // Biens similaires pour les suggestions
        $biensSimilaires = BienImmobilier::with('illustrations')
            ->where('type', $bien->type)
            ->where('id', '!=', $id)
            ->where('statut', 'DISPONIBLE') // MAJUSCULES
            ->limit(4)
            ->get();

        return view('biens.show', compact('bien', 'biensSimilaires'));
    }

    /**
     * Affiche seulement les biens à vendre
     */
    public function aVendre(Request $request)
    {
        if (!Schema::hasTable('biens_immobiliers')) {
            return view('biens.a-vendre', ['biens' => collect()]);
        }

        $query = BienImmobilier::with('illustrations')
            ->where('statut', 'DISPONIBLE') // MAJUSCULES
            ->where('prix', '>', 0);

        if ($request->has('ville') && $request->ville) {
            $query->where('ville', 'like', '%' . $request->ville . '%');
        }

        $biens = $query->orderBy('prix', 'asc')->paginate(12);

        return view('biens.a-vendre', compact('biens'));
    }

    /**
     * Affiche seulement les biens à louer
     */
    public function aLouer(Request $request)
    {
        if (!Schema::hasTable('biens_immobiliers')) {
            return view('biens.a-louer', ['biens' => collect()]);
        }

        $query = BienImmobilier::with('illustrations')
            ->where('statut', 'DISPONIBLE') // MAJUSCULES
            ->where('prix', '>', 0);

        if ($request->has('ville') && $request->ville) {
            $query->where('ville', 'like', '%' . $request->ville . '%');
        }

        $biens = $query->orderBy('prix', 'asc')->paginate(12);

        return view('biens.a-louer', compact('biens'));
    }

    /**
     * Recherche avancée de biens
     */
    public function rechercher(Request $request)
    {
        if (!Schema::hasTable('biens_immobiliers')) {
            return view('biens.recherche', ['biens' => collect()]);
        }

        $query = BienImmobilier::with('illustrations')
            ->where('statut', 'DISPONIBLE'); // MAJUSCULES

        if ($request->has('q') && $request->q) {
            $query->where(function($q) use ($request) {
                $q->where('titre', 'like', '%' . $request->q . '%')
                    ->orWhere('description', 'like', '%' . $request->q . '%')
                    ->orWhere('ville', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->has('prix_min') && $request->prix_min) {
            $query->where('prix', '>=', $request->prix_min);
        }

        if ($request->has('prix_max') && $request->prix_max) {
            $query->where('prix', '<=', $request->prix_max);
        }

        $biens = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('biens.recherche', compact('biens'));
    }

    /**
     * Méthodes REST par défaut
     */
    public function create()
    {
        // Réservé pour l'admin
        abort(404);
    }

    public function store(Request $request)
    {
        // Réservé pour l'admin
        abort(404);
    }

    public function edit($id)
    {
        // Réservé pour l'admin
        abort(404);
    }

    public function update(Request $request, $id)
    {
        // Réservé pour l'admin
        abort(404);
    }

    public function destroy($id)
    {
        // Réservé pour l'admin
        abort(404);
    }
}
