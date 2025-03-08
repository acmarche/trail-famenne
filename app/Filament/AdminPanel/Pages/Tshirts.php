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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Tshirts extends Page implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $title = 'T-shirts résumé';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationIcon = 'tabler-shirt-sport';
    protected static string $view = 'filament.pages.tshirts';

    /**
     * Necessary for group by
     * @param Model $record
     * @return string
     */
   public function getTableRecordKey(Model $record): string
    {
        return (string) $record->id;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Walker::query()
                    ->selectRaw('tshirt_size, COUNT(*) as count')
                    ->groupBy('tshirt_size'),
            )
            ->columns([
                TextColumn::make('tshirt_size'),
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
