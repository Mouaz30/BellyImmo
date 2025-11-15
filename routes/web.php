<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProprietaireController;
use App\Http\Controllers\BienImmobilierController;
use App\Models\BienImmobilier;
use App\Http\Controllers\AccueilController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route::get('/', function () {
//     $biens = BienImmobilier::with('illustrations')
//         ->where('statut', 'disponible')
//         ->limit(6)
//         ->get();

//     return view('front.home', compact('biens')); 
// })->name('home');

Route::get('/', [AccueilController::class, 'index'])->name('home');
Route::get('/biens/{id}', [BienImmobilierController::class, 'show'])->name('biens.show');


Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client/dashboard', [ClientController::class, 'index'])
        ->name('client.dashboard');
});

Route::middleware(['auth', 'role:proprietaire'])->group(function () {
    Route::get('/proprietaire/dashboard', [ProprietaireController::class, 'index'])
        ->name('proprietaire.dashboard');

    Route::get('/proprietaire/biens', [ProprietaireController::class, 'biens'])
        ->name('proprietaire.Bien.list');

    Route::get('/proprietaire/biens/create', [ProprietaireController::class, 'biensCreate'])
        ->name('proprietaire.Bien.create');

    Route::post('/proprietaire/biens', [ProprietaireController::class, 'biensStore'])
        ->name('proprietaire.Bien.store');

    Route::get('/proprietaire/biens/{id}/edit', [ProprietaireController::class, 'biensEdit'])
        ->name('proprietaire.Bien.edit');

    Route::put('/proprietaire/biens/{id}', [ProprietaireController::class, 'biensUpdate'])
        ->name('proprietaire.Bien.update');

    Route::delete('/proprietaire/biens/{id}', [ProprietaireController::class, 'biensDestroy'])
        ->name('proprietaire.Bien.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
