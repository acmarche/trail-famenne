<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\App;

class Homepage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.home';
    public string $locale = '';

    public function getTitle(): string|Htmlable
    {
        return ' ';
    }

    public function __construct()
    {
        $this->localeLanguage();
    }

    public function localeLanguage(): void
    {
        $this->locale = App::getLocale() ?? 'en';
    }

    public static function canAccess(): bool
    {
        return true;
    }

    public function getLayout(): string
    {
        return static::$layout ?? 'filament-panels::components.layout.base';
    }

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::Screen;
    }

}
