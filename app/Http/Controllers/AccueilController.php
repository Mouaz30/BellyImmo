<?php

namespace App\Http\Controllers;

use App\Models\BienImmobilier;
use App\Enums\StatutBien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AccueilController extends Controller
{
    public function index()
    {
        try {
            if (!Schema::hasTable('bien_immobiliers')) {
                return view('front.home', ['biens' => collect()]);
            }

            $biens = BienImmobilier::with('illustrations')
                ->where('statut', StatutBien::DISPONIBLE->value)
                ->orderByDesc('created_at')
                ->get();

            return view('front.home', compact('biens'));

        } catch (\Exception $e) {
            return view('front.home', ['biens' => collect()]);
        }
    }

    public function aPropos()
    {
        return view('a-propos');
    }

    public function contact()
    {
        return view('contact');
    }

    public function envoyerMessage(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'sujet' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        return redirect()->route('contact')
            ->with('success', 'Votre message a été envoyé avec succès !');
    }
}
