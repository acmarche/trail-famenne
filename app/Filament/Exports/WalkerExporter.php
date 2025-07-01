<?php

namespace App\Filament\Exports;

use App\Models\Walker;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class WalkerExporter extends Exporter
{
    protected static ?string $model = Walker::class;

    public static function getColumns(): array
    {
        return [
            'registration_id',
            'first_name',
            'last_name',
            'email',
            'street',
            'city',
            'country',
            'date_of_birth',
            'phone',
            'tshirt_size',
            'tshirt_sex',
            'club_name',
            'display_accepted',
            'newsletter_accepted',
            'gdpr_accepted',
            'regulation_accepted',
            'payment_date',
            'registration_date',
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your wlaker export has completed and '.number_format($export->successful_rows).' '.str('row')->plural(
                $export->successful_rows
            ).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
