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
            ExportColumn::make('registration_id')
                ->label('id'),
            ExportColumn::make('first_name')
                ->label('Prénom'),
            ExportColumn::make('last_name')
                ->label('Nom'),
            ExportColumn::make('email')
                ->label('Email'),
            ExportColumn::make('street')
                ->label('Rue'),
            ExportColumn::make('city')
                ->label('Ville'),
            ExportColumn::make('country')
                ->label('pays'),
            ExportColumn::make('date_of_birth')
                ->label('Né le'),
            ExportColumn::make('phone')
                ->label('Tél'),
            ExportColumn::make('tshirt_size')
                ->label('Taille T-shirt'),
            ExportColumn::make('tshirt_sex')
                ->label('Decoupe T-shirt'),
            ExportColumn::make('club_name')
                ->label('Club'),
            ExportColumn::make('display_accepted')
                ->label('Visible sur le site'),
            ExportColumn::make('newsletter_accepted')
                ->label('Newsletter'),
            ExportColumn::make('gdpr_accepted')
                ->label('Rgpd'),
            ExportColumn::make('regulation_accepted')
                ->label('Regulation'),
            ExportColumn::make('payment_date')
                ->label('Date de payement'),
            ExportColumn::make('registration_date')
                ->label('Date d\'inscription'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your walker export has completed and '.number_format($export->successful_rows).' '.str('row')->plural(
                $export->successful_rows
            ).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
