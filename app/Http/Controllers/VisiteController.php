<?php

namespace App\Http\Controllers;

use App\Models\Visite;
use App\Models\BienImmobilier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisiteController extends Controller
{
    // formulaire
    public function create(BienImmobilier $bien)
    {
        return view('client.visites.create', compact('bien'));
    }

    // enregistrer demande
    public function store(Request $request, BienImmobilier $bien)
    {
        $request->validate([
            'date_visite' => 'required|date|after:today',
            'heure_visite' => 'required',
            'message' => 'nullable|string',
        ]);

        Visite::create([
            'client_id' => Auth::id(),
            'bien_immobilier_id' => $bien->id,
            'date_visite' => $request->date_visite,
            'heure_visite' => $request->heure_visite,
            'message' => $request->message,
            'statut' => 'EN_ATTENTE',
        ]);

        return redirect()
            ->route('client.visites.index')
            ->with('success', 'Votre demande de visite a été envoyée.');
    }

    // liste des demandes du client
    public function index()
    {
        $visites = Visite::where('client_id', Auth::id())
            ->with('bien')
            ->latest()
            ->paginate(10);

        return view('client.visites.index', compact('visites'));
    }
}
