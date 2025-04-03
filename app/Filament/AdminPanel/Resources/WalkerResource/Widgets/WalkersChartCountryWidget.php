<?php

namespace App\Filament\AdminPanel\Resources\WalkerResource\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class WalkersChartCountryWidget extends ChartWidget
{
    protected function getData(): array
    {
        $query = DB::table('walkers')->whereNotNull('payment_date');

        $countryData = $query->select('country', DB::raw('COUNT(*) as count'))
            ->groupBy('country')
            ->pluck('count', 'country')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Newsletter Distribution',
                    'data' => array_values($countryData),
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                    ],
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => array_keys($countryData),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
