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
     * Relation : une illustration appartient à un bien immobilier.
     */
    public function bienImmobilier()
    {
        return $this->belongsTo(BienImmobilier::class);
    }

   
    public function getImageUrlAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }
}
