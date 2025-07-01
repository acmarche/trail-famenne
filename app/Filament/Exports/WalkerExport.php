<?php

namespace App\Filament\Exports;

use App\Models\Walker;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class WalkerExport implements FromCollection, ShouldAutoSize
{
    protected static ?string $model = Walker::class;
    protected array $styles = [];
    protected array $titles = [
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
        'payment_date',
        'registration_date',
    ];

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('first_name')
                ->label('Prénom'),
            ExportColumn::make('last_name')
                ->label('Nom'),
            ExportColumn::make('email')
                ->label('Email'),
        ];
    }

    public function collection(): Collection
    {
        $data = collect();
        $walkers = Walker::query()->get();

        $data->push($this->titles);
        foreach ($walkers as $walker) {
            $data->push([
                $walker->first_name,
                $walker->last_name,
                $walker->email,
                $walker->street,
                $walker->city,
                $walker->country,
                $walker->date_of_birth ? $walker->date_of_birth : '',
                $walker->phone,
                $walker->tshirt_size ? $walker->tshirt_size->value : '',
                $walker->tshirt_sex ? $walker->tshirt_sex->value : '',
                $walker->club_name,
                $walker->payment_date ? $walker->payment_date : '',
                $walker->registration_date ? $walker->registration_date : '',
            ]);
        }

        return $data;
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
