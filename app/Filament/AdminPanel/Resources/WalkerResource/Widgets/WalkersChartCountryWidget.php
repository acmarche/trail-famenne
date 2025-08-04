<?php

namespace App\Filament\AdminPanel\Resources\WalkerResource\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class WalkersChartCountryWidget extends ChartWidget
{
    protected static ?string $heading = 'Par région';

    protected function getData(): array
    {
        $query = DB::table('walkers')->whereNotNull('payment_date');

        $countryData = $query->select('country', DB::raw('COUNT(*) as count'))
            ->groupBy('country')
            ->pluck('count', 'country')
            ->toArray();

        $colors = $this->getColors($countryData);

        return [
            'datasets' => [
                [
                    'label' => 'Country Distribution',
                    'data' => array_values($countryData),
                    'backgroundColor' => $colors,
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => array_keys($countryData),
        ];
    }

    protected function getColors($countryData): array
    {
        $colors = [];
        foreach ($countryData as $country) {
            $r = rand(30, 230);
            $g = rand(30, 230);
            $b = rand(30, 230);

            $colors[] = "rgb({$r}, {$g}, {$b})";
        }

        return $colors;
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
