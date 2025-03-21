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

    public function __construct()
    {
        $this->localeLanguage();
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
            ->query(Walker::query()->whereNotNull('payment_date'))
            ->columns([
                TextColumn::make('first_name')
                    ->label(__('messages.first_name')),
                TextColumn::make('last_name')
                    ->label(__('messages.last_name')),
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
