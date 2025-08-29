<?php

namespace App\Filament\AdminPanel\Resources\WalkerResource\Pages;

use App\Filament\AdminPanel\Pages\PrintWalker;
use App\Filament\AdminPanel\Resources\WalkerResource;
use App\Filament\Exports\WalkerExport;
use App\Models\Walker;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

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
            Actions\Action::make('print')
                ->label('Imprimer')
                ->icon('tabler-printer')
                ->url(fn() => PrintWalker::getUrl()),
            Actions\Action::make('export')
                ->label('Exporter en Xlsx')
                ->icon('tabler-download')
                ->action(
                    fn() => Excel::download(
                        new WalkerExport(),
                        'walkers.xlsx'
                    )
                ),
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
