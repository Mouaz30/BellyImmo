<?php

namespace App\Enums;

enum TypeContrat: string
{
    case LOCATION = 'location';
    case VENTE = 'vente';

    public function label(): string
    {
        return match($this) {
            self::LOCATION => 'Location.php',
            self::VENTE => 'Vente',
        };
    }
}
