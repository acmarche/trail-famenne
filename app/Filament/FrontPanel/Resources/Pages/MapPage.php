<?php

namespace App\Filament\FrontPanel\Resources\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class MapPage extends Page
{
    protected static ?string $navigationIcon = 'tabler-map';
    protected static string $view = 'filament.pages.maps';
    protected static ?string $navigationGroup = 'Informations';

    public function getLayout(): string
    {
        return static::$layout ?? 'filament-panels::components.layout.index';
    }

    public static function canAccess(): bool
    {
        return true;
    }

    public function getTitle(): string|Htmlable
    {
        return __('invoices::messages.page.maps.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('invoices::messages.page.maps.label');
    }
}
