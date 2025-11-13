<?php

namespace App\Enums;

enum TypeBien: string
{
    case MAISON = 'MAISON';    
    case APPARTEMENT = 'APPARTEMENT';
    case COMMERCIAL = 'COMMERCIAL';
    case TERRAIN = 'TERRAIN';
    case VILLA = 'VILLA';

    public function label(): string
    {
        return match($this) {
            self::MAISON => 'Maison',
            self::APPARTEMENT => 'Appartement',
            self::COMMERCIAL => 'Local Commercial',
            self::TERRAIN => 'Terrain',
            self::VILLA => 'Villa',
        };
    }
}
