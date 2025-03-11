<?php

namespace App\Filament\FrontPanel\Resources\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class Rgpd extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.rgpd';

    public array $log=['reason'=>'super'];

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
}
