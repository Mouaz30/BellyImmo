<?php

namespace App\Enums;

enum StatutVente: string
{
    case FINALISE = 'finalise';
    case CONFIRME = 'confirme';
    case ANNULEE  = 'annulee';

    public function label(): string
    {
        return match($this) {
            self::FINALISE => 'Finalisée',
            self::CONFIRME => 'Confirmée',
            self::ANNULEE  => 'Annulée',
        };
    }
}
