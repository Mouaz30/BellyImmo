<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\StatutLocation;

class Location extends Model
{
    protected $fillable = [
        'date_debut',
        'loyer_mensuel',
        'caution',
        'statut',
        'bien_immobilier_id',
        'client_id',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'loyer_mensuel' => 'decimal:2',
        'caution' => 'decimal:2',
        'statut' => StatutLocationEnum::class,
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
