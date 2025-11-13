<?php

namespace App\Enums;

enum UserStatut: string
{
    case ACTIF = 'actif';
    case INACTIF = 'inactif';
    case SUSPENDU = 'suspendu';
}
