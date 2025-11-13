<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\StatutReservation;

class Reservation extends Model
{
    protected $fillable = [
        'date_reservation',
        'statut',
        'bien_immobilier_id',
        'client_id',
    ];

    protected $casts = [
        'date_reservation' => 'date',
        'statut' => StatutReservationEnum::class,
    ];

    public function bienImmobilier()
    {
        return $this->belongsTo(BienImmobilier::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }
}
