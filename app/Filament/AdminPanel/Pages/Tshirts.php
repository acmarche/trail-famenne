<?php

namespace App\Filament\AdminPanel\Pages;

use App\Models\Role;
use App\Models\Walker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Tshirts extends Page implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $title = 'T-shirts résumé';
    protected static ?string $navigationGroup = 'Administration';
    protected static ?string $navigationIcon = 'tabler-shirt-sport';
    protected static string $view = 'filament.pages.tshirts';

    public function getSubheading(): string|Htmlable|null
    {
        return 'Seul les marcheurs ayant payé avant le '.Carbon::parse(config('invoices.TRAIL_TSHIRT_ENDDATE'))->format('d-m-Y').' sont pris en compte';
    }

    /**
     * Necessary for group by
     * @param Model $record
     * @return string
     */
    public function getTableRecordKey(Model $record): string
    {
        return (string)$record->id;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Walker::query()
                    ->where('payment_date', '<', Carbon::parse(config('invoices.TRAIL_TSHIRT_ENDDATE')))
                    ->selectRaw('tshirt_size,tshirt_sex, COUNT(*) as count')
                    ->groupBy('tshirt_size', 'tshirt_sex'),
            )
            ->columns([
                TextColumn::make('tshirt_size')
                    ->label(__('invoices::messages.tshirt_size.label')),
                TextColumn::make('tshirt_sex')
                    ->label(__('invoices::messages.tshirt_sex.label')),
                TextColumn::make('count'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function getLayout(): string
    {
        return static::$layout ?? 'filament-panels::components.layout.index';
    }

    public static function canAccess(): bool
    {
        $isAdmin = auth()->user()?->hasRole(Role::ROLE_ADMIN);

        return $isAdmin ?? false;
    }
}
