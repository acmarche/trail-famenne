<?php

namespace App\Filament\FrontPanel\Resources\Pages;

use App\Http\Middleware\SetLocaleLanguage;
use App\Models\Walker;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class WalkersPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationGroup = 'Informations';
    protected static ?string $navigationIcon = 'tabler-walk';
    //protected ?string $heading = 'Custom Page Heading';
    //protected ?string $subheading = 'Custom Page Subheading';

    public string $locale = '';
    public int $count = 0;

    public function __construct()
    {
        $this->localeLanguage();
        $this->count = Walker::query()->whereNotNull('payment_date')->count();
    }

    public function localeLanguage(): void
    {
        $this->locale = SetLocaleLanguage::getLanguage();
    }

    public function getLayout(): string
    {
        return static::$layout ?? 'filament-panels::components.layout.index';
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(50)
            ->defaultSort('last_name')
            ->query(Walker::query()->whereNotNull('payment_date')->orderBy('last_name'))
            ->columns([
                TextColumn::make('last_name')
                    ->label(__('invoices::messages.last_name'))
                    ->state(fn(Walker $walker) => $walker->display_accepted  ? $walker->first_name : 'Anonyme'),
                TextColumn::make('first_name')
                    ->label(__('invoices::messages.first_name'))
                    ->state(fn(Walker $walker) => $walker->display_accepted  ? $walker->first_name : 'Anonyme'),
                TextColumn::make('city')
                    ->label(__('invoices::messages.city')),
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

    public function getView(): string
    {
        return 'filament.pages.walkers';
    }

    public function getTitle(): string|Htmlable
    {
        return __('invoices::messages.page.walkers.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('invoices::messages.page.walkers.title');
    }

    public static function canAccess(): bool
    {
        return true;
    }


}
