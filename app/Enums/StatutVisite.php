<?php

namespace App\Enums;

enum StatutVisite: string
{
    case EN_ATTENTE = 'EN_ATTENTE';
    case VALIDEE = 'VALIDEE';
    case REFUSEE = 'REFUSEE';

    public function label(): string
    {
        return match($this) {
            self::EN_ATTENTE => 'En attente',
            self::VALIDEE => 'Validée',
            self::REFUSEE => 'Refusée',
        };
    }
}
