<?php

namespace App\Enums;

enum StatutBien: string
{
    case DISPONIBLE = 'disponible';
    case LOUE       = 'loue';
    case VENDU      = 'vendu';
    case RESERVE    = 'reserve';


    public function label(): string
    {
        return match($this) {
            self::DISPONIBLE => 'Disponible',
            self::LOUE   => 'Loue',
            self::VENDU => 'Vendu',
            self::RESERVE => 'Réservé',

        };
    } 
}
