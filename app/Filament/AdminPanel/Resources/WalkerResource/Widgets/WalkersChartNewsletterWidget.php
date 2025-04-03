<?php

namespace App\Filament\AdminPanel\Resources\WalkerResource\Widgets;

use App\Models\Walker;
use Filament\Widgets\ChartWidget;

class WalkersChartNewsletterWidget extends ChartWidget
{
    protected static ?string $heading = 'On souscrit à la lettre d\'informations';

    protected function getData(): array
    {
        $query = Walker::query()->whereNotNull('payment_date');
        $data = ['ok' => 0, 'ko' => 0];
        foreach ($query->get() as $walker) {
            if ($walker->gdpr_accepted === true) {
                $data['ok']++;
            } else {
                $data['ko']++;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Newsletter Distribution',
                    'data' => array_values($data),
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                    ],
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => ['Oui', 'Non'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
