<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BienImmobilier;
use App\Models\IllustrationBien;
use Illuminate\Support\Facades\Storage;
use App\Enums\TypeBien; 
use App\Enums\StatutBien; 
class ProprietaireController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:proprietaire']);
    }

    public function index()
    {
        $user = Auth::user();
        return view('proprietaire.dashboard', compact('user'));
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
        return view('proprietaire.Bien.create');
    }

    public function biensStore(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'adresse' => 'required|string|max:255',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'statut' => 'required|string',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $bienData = array_diff_key($validated, array_flip(['type', 'statut']));

        try {
            $bienData['type'] = TypeBien::from(strtoupper($validated['type']));
            $bienData['statut'] = StatutBien::from(strtoupper($validated['statut']));
            
        } catch (\ValueError $e) {
            return back()->withInput()->withErrors(['message' => 'Type ou Statut de bien invalide. Veuillez vérifier les options disponibles.']);
        }

        $bien = BienImmobilier::create([
            ...$bienData, 
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

        return view('proprietaire.Bien.edit', compact('bien'));
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
            'type' => 'required|string',
            'description' => 'nullable|string',
            'statut' => 'required|string',
            'images.*' => 'nullable|image|max:2048',
        ]);
        
        $bienData = array_diff_key($validated, array_flip(['type', 'statut']));
        
        try {
            $bienData['type'] = TypeBien::from(strtoupper($validated['type']));
            $bienData['statut'] = StatutBien::from(strtoupper($validated['statut']));
            
        } catch (\ValueError $e) {
            return back()->withInput()->withErrors(['message' => 'Type ou Statut de bien invalide. Veuillez vérifier les options disponibles.']);
        }

        $bien->update($bienData); 

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
}