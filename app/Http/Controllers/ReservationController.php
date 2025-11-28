<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\BienImmobilier;
use App\Models\Paiement;
use App\Enums\StatutReservation;
use App\Enums\TypeReservation;
use App\Enums\StatutPaiement;
use App\Enums\MethodePaiement;
use App\Enums\StatutBien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Liste des réservations du client connecté
     */
    public function index()
    {
        $reservations = Reservation::with(['bienImmobilier', 'paiement'])
            ->where('client_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('client.reservations.index', compact('reservations'));
    }

    /**
     * Formulaire de création d’une réservation
     */
    public function create(BienImmobilier $bienImmobilier)
    {
        if ($bienImmobilier->statut !== StatutBien::DISPONIBLE) {
            return redirect()
                ->back()
                ->with('error', 'Ce bien n’est pas disponible pour la réservation.');
        }

        return view('client.reservations.create', [
            'bien' => $bienImmobilier,
            'methodesPaiement' => MethodePaiement::cases(),
        ]);
    }

    /**
     * Enregistrer une réservation
     */
    public function store(Request $request, BienImmobilier $bienImmobilier)
    {
        $request->validate([
            'dateReservation' => 'required|date|after:today',
            'methode_paiement' => 'required|in:OM,WAVE,ESPECES,CB',
        ]);

        if ($bienImmobilier->statut !== StatutBien::DISPONIBLE) {
            return redirect()->back()->with('error', 'Ce bien n’est plus disponible.');
        }

        // Déterminer automatiquement le type de réservation
        $typeReservation = $bienImmobilier->mode_transaction->value === 'location'
                            ? TypeReservation::LOCATION
                            : TypeReservation::ACHAT;

        // Calcul montant selon mode transaction
        if ($bienImmobilier->mode_transaction->value === 'location') {
            $montant = $bienImmobilier->prix; // paiement total
        } else {
            $montant = $bienImmobilier->prix * 0.10; // acompte 10%
        }

        // Création réservation
        $reservation = Reservation::create([
            'bien_immobilier_id' => $bienImmobilier->id,
            'client_id' => Auth::id(),
            'prix' => $bienImmobilier->prix,
            'statut' => StatutReservation::EN_ATTENTE,
            'type' => $typeReservation,
            'dateReservation' => $request->dateReservation,
        ]);

        // Création paiement
        Paiement::create([
            'reservation_id' => $reservation->id,
            'montant' => $montant,
            'date_paiement' => now(),
            'methode' => $request->methode_paiement,
            'statut' => StatutPaiement::EN_ATTENTE,
        ]);

        // Mise à jour statut du bien
        $bienImmobilier->update([
            'statut' => StatutBien::RESERVE,
        ]);

        return redirect()
            ->route('client.reservations.show', $reservation)
            ->with('success', 'Réservation enregistrée avec succès !');
    }

    /**
     * Afficher une réservation
     */
    public function show(Reservation $reservation)
    {
        // Vérifier que la réservation appartient au client
        if ($reservation->client_id !== Auth::id()) {
            abort(403, 'Accès interdit.');
        }

        $reservation->load(['bienImmobilier', 'paiement']);

        return view('client.reservations.show', compact('reservation'));
    }

    /**
     * Page de paiement
     */
    public function paiement(Reservation $reservation)
    {
        if ($reservation->client_id !== Auth::id()) {
            abort(403, 'Accès interdit.');
        }

        $reservation->load('paiement');

         return view('client.reservations.paiement', compact('reservation'));
    }

    /**
     * Traitement du paiement
     */
    public function processPaiement(Request $request, Reservation $reservation)
    {
        if ($reservation->client_id !== Auth::id()) {
            abort(403, 'Accès interdit.');
        }

        $reservation->paiement->update([
            'statut' => StatutPaiement::PAYE,
            'date_paiement' => now(),
        ]);

        $reservation->update([
            'statut' => StatutReservation::CONFIRMEE,
        ]);

        return redirect()
            ->route('client.reservations.show', $reservation)
            ->with('success', 'Paiement effectué et réservation confirmée !');
    }

    /**
     * Annulation réservation (client)
     */
    public function cancel(Request $request, Reservation $reservation)
    {
        if ($reservation->client_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        if ($reservation->statut !== StatutReservation::EN_ATTENTE) {
            return redirect()->back()->with('error', 'Impossible d’annuler cette réservation.');
        }

        $reservation->update([
            'statut' => StatutReservation::ANNULEE,
        ]);

        $reservation->bienImmobilier->update([
            'statut' => StatutBien::DISPONIBLE,
        ]);

        if ($reservation->paiement) {
            $reservation->paiement->update([
                'statut' => StatutPaiement::ANNULE,
            ]);
        }

        return redirect()
            ->route('client.reservations.index')
            ->with('success', 'Réservation annulée avec succès.');
    }

    /**
     * Reçu PDF
     */
    public function receipt(Reservation $reservation)
    {
        if ($reservation->client_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        $reservation->load(['bienImmobilier', 'paiement', 'client']);

        return view('reservations.receipt', compact('reservation'));
    }

    public function sendContact(Request $request)
{
    $request->validate([
        'prenom' => 'required|string|max:100',
        'nom' => 'required|string|max:100',
        'email' => 'required|email',
        'telephone' => 'nullable|string|max:50',
        'message' => 'required|string|max:2000',
    ]);

    // Traitement (email, stockage, log...)
    // Mail::to("contact@bellyimmo.com")->send(new ContactMail($request->all()));

    return back()->with('success', 'Votre message a été envoyé avec succès.');
}

}
