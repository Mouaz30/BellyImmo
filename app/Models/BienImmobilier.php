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
    /**
     * Laravel gère automatiquement created_at / updated_at
     */
    public $timestamps = true;

    /**
     * Champs autorisés
     */
    protected $fillable = [
        'titre',
        'prix',
        'adresse',
        'type',
        'description',
        'statut',
        'proprietaire_id',
    ];

    /**
     * Casts automatiques
     */
    protected $casts = [
        'prix' => 'decimal:2',
        'type' => TypeBien::class,
        'statut' => StatutBien::class,
    ];

    /**
     * 🔗 Relations Eloquent
     */

    // Plusieurs images pour un bien
    public function illustrations()
    {
        return $this->hasMany(IllustrationBien::class, 'bien_immobilier_id');
    }

    // Propriétaire du bien
    public function proprietaire()
    {
        return $this->belongsTo(User::class, 'proprietaire_id');
    }

    // Réservations liées au bien
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // Locations liées
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    // Ventes liées
    public function ventes()
    {
        return $this->hasMany(Vente::class);
    }

    /**
     * 🧠 Accesseur : nom complet du propriétaire
     */
    public function getProprietaireFullNameAttribute(): ?string
    {
        if (!$this->proprietaire) {
            return null;
        }

        return trim($this->proprietaire->nom . ' ' . $this->proprietaire->prenom);
    }

    /**
     * Retourne la valeur texte du type
     */
    public function getTypeValueAttribute(): ?string
    {
        return $this->type?->value;
    }

    /**
     * Retourne la valeur texte du statut
     */
    public function getStatutValueAttribute(): ?string
    {
        return $this->statut?->value;
    }
}
