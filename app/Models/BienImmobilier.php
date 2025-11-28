<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\StatutBien;
use App\Enums\TypeBien;
use App\Models\User;
use App\Models\IllustrationBien;
use App\Models\Reservation;
use App\Models\Location;
use App\Models\Vente;

class BienImmobilier extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'titre',
        'prix',
        'adresse',
        'type',
        'description',
        'statut',
        'proprietaire_id',
        'mode_transaction',
    ];

    /**
     * Casts ENUM + prix
     */
    protected $casts = [
        'prix' => 'decimal:2',
        'type' => TypeBien::class,
        'statut' => StatutBien::class,
       // 'mode_transaction' => ModeTransaction::class,
       'mode_transaction' => \App\Enums\ModeTransaction::class,
    ];

    /**
     * Relations
     */
    public function illustrations()
    {
        return $this->hasMany(IllustrationBien::class, 'bien_immobilier_id');
    }

    public function proprietaire()
    {
        return $this->belongsTo(User::class, 'proprietaire_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function ventes()
    {
        return $this->hasMany(Vente::class);
    }

    /**
     * Accessors utiles
     */
    public function getProprietaireFullNameAttribute(): ?string
    {
        if (!$this->proprietaire) {
            return null;
        }

        return trim($this->proprietaire->nom . ' ' . $this->proprietaire->prenom);
    }

    public function getTypeValueAttribute(): ?string
    {
        return $this->type?->value;
    }

    public function getStatutValueAttribute(): ?string
    {
        return $this->statut?->value;
    }
}
