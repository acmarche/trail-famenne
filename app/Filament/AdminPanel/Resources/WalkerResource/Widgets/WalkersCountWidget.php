<?php

namespace App\Filament\AdminPanel\Resources\WalkerResource\Widgets;


use App\Models\Walker;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WalkersCountWidget extends BaseWidget
{
    protected ?string $heading = 'Statistiques';

    protected ?string $description = 'Résumé des inscriptions';

    protected function getStats(): array
    {
        $walkersCountUnpaid = Walker::registrationsNotPaidCount();
        $walkersCountPaid = Walker::registrationsPaidCount();

        return [
            Stat::make('Marcheurs validés', $walkersCountPaid)
                ->description('Nombre de marcheurs ayant payé')
                ->icon('tabler-walk')
                ->color('success'),

            Stat::make('Marcheurs non validés', $walkersCountUnpaid)
                ->description('Nombre de marcheurs n\'ayant pas payés')
                ->icon('tabler-walk')
                ->color('danger'),
        ];
    }
}
