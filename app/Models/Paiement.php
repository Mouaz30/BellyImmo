<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\MethodePaiement;
use App\Enums\StatutPaiement;

class Paiement extends Model
{
    protected $fillable = [
        'montant',
        'date_paiement',
        'methode',
        'statut',
        'reservation_id',
        'location_id',
        'vente_id',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_paiement' => 'date',
        'methode' => MethodePaiement::class,
        'statut' => StatutPaiement::class,
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function vente()
    {
        return $this->belongsTo(Vente::class);
    }
}
