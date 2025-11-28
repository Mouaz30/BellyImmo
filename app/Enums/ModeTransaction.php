<?php

namespace App\Enums;

enum ModeTransaction: string
{
    case LOCATION = 'location';
    case VENTE = 'vente';

    public function label(): string
    {
        return match($this) {
            self::LOCATION => 'Location',
            self::VENTE => 'Vente',
        };
    }
}
