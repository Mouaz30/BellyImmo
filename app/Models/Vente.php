<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\StatutVente;

class Vente extends Model
{
    protected $fillable = [
        'prix_final',
        'statut',
        'bien_immobilier_id',
        'client_id',
    ];

    protected $casts = [
        'prix_final' => 'decimal:2',
        'statut' => StatutVenteEnum::class,
    ];

    public function bienImmobilier()
    {
        return $this->belongsTo(BienImmobilier::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
}
