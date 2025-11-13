<?php

namespace App\Filament\Resources\BienImmobilierResource\Pages;

use App\Filament\Resources\BienImmobilierResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBienImmobiliers extends ListRecords
{
    protected static string $resource = BienImmobilierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
