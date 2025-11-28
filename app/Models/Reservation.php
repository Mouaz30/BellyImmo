<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Enums\StatutReservation;
use App\Enums\TypeReservation;

class Reservation extends Model
{
    protected $fillable = [
        'bien_immobilier_id',
        'client_id',
        'prix',
        'statut',
        'type',
        'dateReservation'
    ];

    protected $casts = [
        'statut' => StatutReservation::class,
        'type' => TypeReservation::class,
        'dateReservation' => 'datetime',
        'prix' => 'decimal:2'
    ];

    /**
     * Relations
     */
    public function bienImmobilier(): BelongsTo
    {
        return $this->belongsTo(BienImmobilier::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function paiement(): HasOne
    {
        return $this->hasOne(Paiement::class);
    }

    /**
     * Scopes
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', StatutReservation::EN_ATTENTE);
    }

    public function scopeConfirmees($query)
    {
        return $query->where('statut', StatutReservation::CONFIRMEE);
    }

    /**
     * Helpers
     */
    public function estEnAttente(): bool
    {
        return $this->statut === StatutReservation::EN_ATTENTE;
    }

    public function estConfirmee(): bool
    {
        return $this->statut === StatutReservation::CONFIRMEE;
    }

    public function aUnPaiement(): bool
    {
        return $this->paiement !== null;
    }

    public function paiementEstPaye(): bool
    {
        return $this->paiement && $this->paiement->statut === 'PAYE';
    }
}
