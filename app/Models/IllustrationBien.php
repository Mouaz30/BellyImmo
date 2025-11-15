<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IllustrationBien extends Model
{
    protected $fillable = [
        'libelle',
        'image_url',
        'bien_immobilier_id',
    ];

    /**
     * Relation : une illustration appartient à un bien immobilier
     */
    public function bienImmobilier()
    {
        return $this->belongsTo(BienImmobilier::class, 'bien_immobilier_id');
    }

    /**
     * Accesseur : retourne une URL complète vers l’image stockée
     */
    public function getImageUrlAttribute($value)
    {
        return $value
            ? asset('storage/' . ltrim($value, '/'))
            : asset('images/default.png');
    }
}
