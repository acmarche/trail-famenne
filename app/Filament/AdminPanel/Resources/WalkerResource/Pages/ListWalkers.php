<?php

namespace App\Filament\AdminPanel\Resources\WalkerResource\Pages;

use App\Filament\AdminPanel\Resources\WalkerResource;
use App\Filament\Exports\WalkerExporter;
use App\Models\Walker;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListWalkers extends ListRecords
{
    protected static string $resource = WalkerResource::class;

    private int $walkersAll;
    private int $walkersCountUnpaid;
    private int $walkersCountPaid;

    public function __construct()
    {
        $this->walkersAll = Walker::countAll();
        $this->walkersCountUnpaid = Walker::unpaidCount();
        $this->walkersCountPaid = Walker::paidCount();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Ajouter un marcher')
                ->icon('tabler-plus'),
            Actions\ExportAction::make()
                ->label('Exporter la liste')
                ->icon('tabler-file-type-xls')
                ->exporter(WalkerExporter::class),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All')
                ->label('Tous')
                ->badge(function (): int {
                    return $this->walkersAll;
                }),
            'not_paid' => Tab::make('Not paid')
                ->badge(function (): int {
                    return $this->walkersCountUnpaid;
                })
                ->label('Non payé')
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->whereNull('payment_date');
                }),
            'paid' => Tab::make('Paid')
                ->label('Payé')
                ->badge(function (): int {
                    return $this->walkersCountPaid;
                })
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->whereNotNull('payment_date');
                }),
        ];
    }
}
