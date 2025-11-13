<?php

namespace App\Enums;

enum TypeReservation: string
{
    case LOCATION = 'location';
    case ACHAT = 'achat';

    public function label(): string
    {
        return match($this) {
            self::LOCATION => 'Location.php',
            self::ACHAT => 'Achat',
        };
    }
}
