<?php

namespace App\Filament\AdminPanel\Resources\WalkerResource\Widgets;

use App\Models\Walker;
use Filament\Widgets\ChartWidget;

class WalkersChartBirthdayWidget extends ChartWidget
{
    protected static ?string $heading = 'Ages des participants';

    protected function getData(): array
    {
        $query = Walker::query()->whereNotNull('payment_date');

        $ageGroups = [
            '0-18' => 0,
            '19-30' => 0,
            '31-50' => 0,
            '51' => 0,
        ];

        foreach ($query->get() as $walker) {
            $age = $walker->age();
            match (true) {
                $age >= 0 && $age <= 18 => $ageGroups['0-18']++,
                $age >= 19 && $age <= 30 => $ageGroups['19-30']++,
                $age >= 31 && $age <= 50 => $ageGroups['31-50']++,
                $age >= 51 => $ageGroups['51']++,
                default => null,
            };
        }

        return [
            'datasets' => [
                [
                    'label' => 'Age Distribution',
                    'data' => array_values($ageGroups),
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(54, 162, 235)',
                        'rgb(162, 205, 86)'
                    ],
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => ['0-18', '19-30', '31-50', '51+'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
