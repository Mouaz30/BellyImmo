<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProprietaireController;
use App\Http\Controllers\BienImmobilierController;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\VisiteController;

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/

Route::get('/', [AccueilController::class, 'index'])->name('home');

Route::get('/biens/{id}', [BienImmobilierController::class, 'show'])->name('biens.show');

Route::get('/contact', function () {
    return view('front.contact');
})->name('contact');


Route::post('/contact/send', [ReservationController::class, 'sendContact'])
    ->name('contact.send');
/*
|--------------------------------------------------------------------------
| Routes CLIENT (auth + rôle client)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:client'])->prefix('client')->group(function () {

    Route::get('/dashboard', [ClientController::class, 'index'])
        ->name('client.dashboard');

    /** Liste des réservations */
    Route::get('/reservations', [ReservationController::class, 'index'])
        ->name('client.reservations.index');

    /** Créer une réservation */
    Route::get('/reservations/create/{bienImmobilier}', [ReservationController::class, 'create'])
        ->name('client.reservations.create');

    /** Enregistrer une réservation */
    Route::post('/reservations/store/{bienImmobilier}', [ReservationController::class, 'store'])
        ->name('client.reservations.store');

    /** Voir une réservation */
    Route::get('/reservations/{reservation}/show', [ReservationController::class, 'show'])
        ->name('client.reservations.show');

    /** Annuler une réservation */
    Route::post('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])
        ->name('client.reservations.cancel');

    /** Page de paiement */
    Route::get('/reservations/{reservation}/paiement', [ReservationController::class, 'paiement'])
        ->name('client.reservations.paiement');

    /** Traitement du paiement */
    Route::post('/reservations/{reservation}/paiement', [ReservationController::class, 'processPaiement'])
        ->name('client.reservations.processPaiement');

    /** Reçu PDF */
    Route::get('/reservations/{reservation}/receipt', [ReservationController::class, 'receipt'])
        ->name('client.reservations.receipt');


        /** Liste des demandes du client */
    Route::get('/visites', [VisiteController::class, 'index'])
        ->name('client.visites.index');

    /** Formulaire demande de visite */
    Route::get('/visites/demande/{bien}', [VisiteController::class, 'create'])
        ->name('client.visites.create');

    /** Enregistrer une demande de visite */
    Route::post('/visites/demande/{bien}', [VisiteController::class, 'store'])
        ->name('client.visites.store');
});


/*
|--------------------------------------------------------------------------
| Routes PROPRIÉTAIRE (auth + rôle proprietaire)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:proprietaire'])->group(function () {

    Route::get('/proprietaire/dashboard', [ProprietaireController::class, 'index']) ->name('proprietaire.dashboard');

    Route::get('/proprietaire/biens', [ProprietaireController::class, 'biens'])->name('proprietaire.Bien.list');

    Route::get('/proprietaire/biens/create', [ProprietaireController::class, 'biensCreate'])->name('proprietaire.Bien.create');

    Route::post('/proprietaire/biens', [ProprietaireController::class, 'biensStore'])->name('proprietaire.Bien.store');

    Route::get('/proprietaire/biens/{id}/edit', [ProprietaireController::class, 'biensEdit'])->name('proprietaire.Bien.edit');

    Route::put('/proprietaire/biens/{id}', [ProprietaireController::class, 'biensUpdate'])->name('proprietaire.Bien.update');

    Route::delete('/proprietaire/biens/{id}', [ProprietaireController::class, 'biensDestroy'])->name('proprietaire.Bien.destroy');

    Route::get('/proprietaire/reservations', [ProprietaireController::class, 'reservations'])->name('proprietaire.reservations.index');

    Route::get('/proprietaire/reservations/{id}', [ProprietaireController::class, 'showReservation'])->name('proprietaire.reservations.show');

    Route::post('/proprietaire/reservations/{id}/accept', [ProprietaireController::class, 'acceptReservation'])->name('proprietaire.reservations.accept');

    Route::post('/proprietaire/reservations/{id}/reject', [ProprietaireController::class, 'rejectReservation'])->name('proprietaire.reservations.reject');


    /** Liste des visites reçues pour ses biens */
    Route::get('/proprietaire/visites', [ProprietaireController::class, 'visites'])->name('proprietaire.visites.index');

    /** Détail d'une visite */
    Route::get('/proprietaire/visites/{id}', [ProprietaireController::class, 'showVisite'])->name('proprietaire.visites.show');

    /** Accepter une visite */
    Route::post('/proprietaire/visites/{id}/accepter', [ProprietaireController::class, 'accepterVisite'])->name('proprietaire.visites.accept');

    /** Refuser une visite */
    Route::post('/proprietaire/visites/{id}/refuser', [ProprietaireController::class, 'refuserVisite'])->name('proprietaire.visites.reject');
});


/*
|--------------------------------------------------------------------------
| Routes Profil Authentifié (tous les users)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';
