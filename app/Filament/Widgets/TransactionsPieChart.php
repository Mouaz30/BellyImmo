<?php

namespace App\Filament\Widgets;

use App\Models\BienImmobilier;
use Filament\Widgets\PieChartWidget;

class TransactionsPieChart extends PieChartWidget
{
    protected static ?string $heading = 'Répartition Vente / Location';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'data' => [
                        BienImmobilier::where('mode_transaction', 'vente')->count(),
                        BienImmobilier::where('mode_transaction', 'location')->count(),
                    ],
                ],
            ],
            'labels' => ['Vente', 'Location'],
        ];
    }
}
