<?php

namespace App\Filament\FrontPanel\Resources\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class RgpdPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.rgpd';
    protected static ?string $navigationGroup = 'Informations';

    protected static bool $shouldRegisterNavigation = false;

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
        return __('invoices::messages.page.rgpd.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('invoices::messages.page.rgpd.label');
    }
}
