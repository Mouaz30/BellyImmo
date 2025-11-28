<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:client']);
    }

    /**
     * Dashboard Client
     */
    public function index()
    {
        $user = Auth::user();

        // STATISTIQUES
        $reservationsEnAttente = Reservation::where('client_id', $user->id)
            ->where('statut', 'en_attente')
            ->count();

        $reservationsConfirmees = Reservation::where('client_id', $user->id)
            ->where('statut', 'confirmee')
            ->count();

        $paiementsEnAttente = Reservation::where('client_id', $user->id)
            ->whereHas('paiement', fn($q) => $q->where('statut', 'en_attente'))
            ->count();

        // DERNIÈRES RÉSERVATIONS
        $dernieresReservations = Reservation::where('client_id', $user->id)
            ->with('bienImmobilier')
            ->latest()
            ->take(5)
            ->get();

        return view('client.dashboard', [
            'user' => $user,
            'reservationsEnAttente' => $reservationsEnAttente,
            'reservationsConfirmees' => $reservationsConfirmees,
            'paiementsEnAttente' => $paiementsEnAttente,
            'dernieresReservations' => $dernieresReservations,
        ]);
    }
}
