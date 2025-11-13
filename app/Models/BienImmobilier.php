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
     * Si votre table ne contient pas les colonnes created_at / updated_at.
     * (Sinon, supprimez cette propriété)
     */
    public $timestamps = false;

    /**
     * Champs autorisés à être remplis en masse (mass assignment)
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
     * Casts automatiques pour les attributs du modèle
     */
    protected $casts = [
        'prix' => 'decimal:2',
        'type' => TypeBien::class,
        'statut' => StatutBien::class,
    ];

    /**
     * 🔗 Relations
     */

    // Un bien peut avoir plusieurs images
    public function illustrations()
    {
        return $this->hasMany(IllustrationBien::class);
    }

    // Un bien appartient à un propriétaire (utilisateur)
    public function proprietaire()
    {
        return $this->belongsTo(User::class, 'proprietaire_id');
    }

    // Un bien peut avoir plusieurs réservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // Un bien peut être loué plusieurs fois
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    // Un bien peut avoir plusieurs ventes (historique)
    public function ventes()
    {
        return $this->hasMany(Vente::class);
    }

    /**
     * 🧠 Accesseur personnalisé :
     * Retourne le nom complet du propriétaire s’il existe
     */
    public function getProprietaireFullNameAttribute(): ?string
    {
        if (!$this->proprietaire) {
            return null;
        }

        return trim($this->proprietaire->nom . ' ' . $this->proprietaire->prenom);
    }

    /**
     * 🧩 Accesseur pratique :
     * Retourne la valeur texte du type (Enum)
     */
    public function getTypeValueAttribute(): ?string
    {
        return $this->type?->value;
    }

    /**
     * Retourne la valeur texte du statut (Enum)
     */
    public function getStatutValueAttribute(): ?string
    {
        return $this->statut?->value;
    }
}
