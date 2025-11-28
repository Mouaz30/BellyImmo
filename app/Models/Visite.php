<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visite extends Model
{
    protected $fillable = [
        'client_id',
        'bien_immobilier_id',
        'date_visite',
        'heure_visite',
        'message',
        'statut',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function bien()
    {
        return $this->belongsTo(BienImmobilier::class, 'bien_immobilier_id');
    }
}
