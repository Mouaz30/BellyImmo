<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation; 
use App\Models\BienImmobilier;
use App\Models\IllustrationBien;
use Illuminate\Support\Facades\Storage;
use App\Enums\TypeBien; 
use App\Enums\StatutBien; 
use App\Models\Visite;
use App\Notifications\VisiteStatusChanged;
use App\Enums\StatutVisite;

class ProprietaireController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:proprietaire']);
    }

   public function index()
{
    $user = Auth::user();

    // STATISTIQUES
    $biensCount = $user->biens()->count();

    $reservationsTotal = \App\Models\Reservation::whereHas('bienImmobilier', function ($q) use ($user) {
            $q->where('proprietaire_id', $user->id);
        })
        ->count();

    $reservationsEnAttente = \App\Models\Reservation::whereHas('bienImmobilier', function ($q) use ($user) {
            $q->where('proprietaire_id', $user->id);
        })
        ->where('statut', 'en_attente')
        ->count();

    $reservationsConfirmees = \App\Models\Reservation::whereHas('bienImmobilier', function ($q) use ($user) {
            $q->where('proprietaire_id', $user->id);
        })
        ->where('statut', 'confirmee')
        ->count();

    // DERNIÈRES RÉSERVATIONS
    $derniereReservations = \App\Models\Reservation::whereHas('bienImmobilier', function ($q) use ($user) {
            $q->where('proprietaire_id', $user->id);
        })
        ->with(['bienImmobilier', 'client'])
        ->latest()
        ->take(5)
        ->get();

    // DERNIERS BIENS
    $biensRecents = $user->biens()
        ->latest()
        ->take(6)
        ->get();

    return view('proprietaire.dashboard', compact(
        'user',
        'biensCount',
        'reservationsTotal',
        'reservationsEnAttente',
        'reservationsConfirmees',
        'derniereReservations',
        'biensRecents'
    ));
}


    /**
     * Affiche la liste des biens du propriétaire connecté.
     */
    public function biens()
    {
        $user = Auth::user(); 
        $biens = BienImmobilier::where('proprietaire_id', $user->id) 
                            ->with('illustrations')
                            ->get();

        return view('proprietaire.Bien.list', compact('biens', 'user'));
    }

    public function biensCreate()
    {
        $types = TypeBien::cases();
        $statuts = StatutBien::cases();
        
        return view('proprietaire.Bien.create', compact('types', 'statuts'));
    }

    public function biensStore(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'adresse' => 'required|string|max:255',
            'type' => 'required|string|in:' . implode(',', array_column(TypeBien::cases(), 'value')),
            'description' => 'nullable|string',
            'mode_transaction' => 'required|in:location,vente',
            'statut' => 'required|string|in:' . implode(',', array_column(StatutBien::cases(), 'value')),
            'images.*' => 'nullable|image|max:2048',
        ]);

        try {
            $bien = BienImmobilier::create([
                'titre' => $validated['titre'],
                'prix' => $validated['prix'],
                'adresse' => $validated['adresse'],
                'type' => TypeBien::from($validated['type']),
                'description' => $validated['description'],
                'statut' => StatutBien::from($validated['statut']),
                'proprietaire_id' => Auth::id(),
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('biens', 'public'); 
                    IllustrationBien::create([
                        'libelle' => $image->getClientOriginalName(),
                        'image_url' => $path,
                        'bien_immobilier_id' => $bien->id,
                    ]);
                }
            }

            return redirect()->route('proprietaire.Bien.list')
                ->with('success', 'Bien ajouté avec succès.');

        } catch (\ValueError $e) {
            return back()->withInput()->withErrors([
                'message' => 'Type ou Statut de bien invalide. Veuillez vérifier les options disponibles.'
            ]);
        }
    }

    /**
     * Affiche le formulaire d'édition d'un bien.
     */
    public function biensEdit($id)
    {
        $bien = BienImmobilier::with('illustrations')->findOrFail($id);
        
        if ($bien->proprietaire_id !== Auth::id()) {
            abort(403, 'Accès non autorisé. Ce bien ne vous appartient pas.'); 
        }

        $types = TypeBien::cases();
        $statuts = StatutBien::cases();

        return view('proprietaire.Bien.edit', compact('bien', 'types', 'statuts'));
    }

    /**
     * Met à jour un bien.
     */
    public function biensUpdate(Request $request, $id)
    {
        $bien = BienImmobilier::findOrFail($id);

        if ($bien->proprietaire_id !== Auth::id()) {
            abort(403, 'Accès non autorisé. Ce bien ne vous appartient pas.'); 
        }

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'adresse' => 'required|string|max:255',
            'type' => 'required|string|in:' . implode(',', array_column(TypeBien::cases(), 'value')),
            'description' => 'nullable|string',
            'statut' => 'required|string|in:' . implode(',', array_column(StatutBien::cases(), 'value')),
            'images.*' => 'nullable|image|max:2048',
        ]);
        
        try {
            $bien->update([
                'titre' => $validated['titre'],
                'prix' => $validated['prix'],
                'adresse' => $validated['adresse'],
                'type' => TypeBien::from($validated['type']),
                'description' => $validated['description'],
                'statut' => StatutBien::from($validated['statut']),
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('biens', 'public');
                    IllustrationBien::create([
                        'libelle' => $image->getClientOriginalName(),
                        'image_url' => $path,
                        'bien_immobilier_id' => $bien->id,
                    ]);
                }
            }

            return redirect()->route('proprietaire.Bien.list')
                ->with('success', 'Bien mis à jour avec succès.');

        } catch (\ValueError $e) {
            return back()->withInput()->withErrors([
                'message' => 'Type ou Statut de bien invalide. Veuillez vérifier les options disponibles.'
            ]);
        }
    }

    public function biensDestroy($id)
    {
        $bien = BienImmobilier::findOrFail($id);

        if ($bien->proprietaire_id !== Auth::id()) {
            abort(403, 'Accès non autorisé. Ce bien ne vous appartient pas.'); 
        }
        
        foreach ($bien->illustrations as $illustration) {
            Storage::disk('public')->delete($illustration->image_url);
            $illustration->delete();
        }
        
        $bien->delete();
        
        return back()->with('success', 'Bien supprimé avec succès.');
    }

    /**
 * Affiche les réservations des biens du propriétaire
 */
public function reservations()
{
    $user = Auth::user();
    $reservations = Reservation::whereHas('bienImmobilier', function($query) use ($user) {
            $query->where('proprietaire_id', $user->id);
        })
        ->with(['bienImmobilier', 'client'])
        ->orderBy('created_at', 'desc')
        ->get();

    return view('proprietaire.reservations.index', compact('reservations', 'user'));
}

/**
 * Affiche les détails d'une réservation
 */
public function showReservation($id)
{
    $reservation = Reservation::with(['bienImmobilier', 'client'])
        ->findOrFail($id);

    if ($reservation->bienImmobilier->proprietaire_id !== Auth::id()) {
        abort(403, 'Accès non autorisé.');
    }

    return view('proprietaire.reservations.show', compact('reservation'));
}

/**
 * Accepte une réservation
 */
public function acceptReservation($id)
{
    $reservation = Reservation::findOrFail($id);

    if ($reservation->bienImmobilier->proprietaire_id !== Auth::id()) {
        abort(403, 'Accès non autorisé.');
    }

    try {
        $reservation->update([
            'statut' => \App\Enums\StatutReservation::CONFIRMEE,
        ]);

        return back()->with('success', 'Réservation acceptée avec succès.');

    } catch (\Exception $e) {
        return back()->withErrors(['message' => 'Une erreur est survenue.']);
    }
}

/**
 * Rejette une réservation
 */
public function rejectReservation($id)
{
    $reservation = Reservation::findOrFail($id);

    if ($reservation->bienImmobilier->proprietaire_id !== Auth::id()) {
        abort(403, 'Accès non autorisé.');
    }

    try {
        $reservation->update([
            'statut' => \App\Enums\StatutReservation::ANNULEE,
        ]);

        return back()->with('success', 'Réservation rejetée avec succès.');

    } catch (\Exception $e) {
        return back()->withErrors(['message' => 'Une erreur est survenue.']);
    }
}


    /**
 * Liste toutes les demandes de visite pour les biens du propriétaire
 */
public function visites()
{
    $user = Auth::user();

    $visites = Visite::with(['bien', 'client'])
        ->whereHas('bien', function ($q) use ($user) {
            $q->where('proprietaire_id', $user->id);
        })
        ->latest()
        ->paginate(10);

    return view('proprietaire.visites.index', compact('visites'));
}

/**
 * Affiche le détail d'une demande de visite
 */
public function showVisite($id)
{
    $user = Auth::id();

    $visite = Visite::with(['bien', 'client'])
        ->where('id', $id)
        ->whereHas('bien', function ($q) use ($user) {
            $q->where('proprietaire_id', $user);
        })
        ->firstOrFail();

    return view('proprietaire.visites.show', compact('visite'));
}

/**
 * Accepter une visite
 */
public function accepterVisite($id)
{
    $user = Auth::id();

    $visite = Visite::with(['bien', 'client'])
        ->where('id', $id)
        ->whereHas('bien', function ($q) use ($user) {
            $q->where('proprietaire_id', $user);
        })
        ->firstOrFail();

    $visite->update([
        'statut' => StatutVisite::VALIDEE->value,
    ]);

    $visite->client->notify(new VisiteStatusChanged($visite));

    return redirect()->route('proprietaire.visites.index')
        ->with('success', 'Visite acceptée et notification envoyée.');
}

/**
 * Refuser une visite
 */
public function refuserVisite($id)
{
    $user = Auth::id();

    $visite = Visite::with(['bien', 'client'])
        ->where('id', $id)
        ->whereHas('bien', function ($q) use ($user) {
            $q->where('proprietaire_id', $user);
        })
        ->firstOrFail();

    $visite->update([
        'statut' => StatutVisite::REFUSEE->value,
    ]);

    $visite->client->notify(new VisiteStatusChanged($visite));

    return redirect()->route('proprietaire.visites.index')
        ->with('success', 'Visite refusée et notification envoyée.');
}

}