<?php

namespace App\Filament\FrontPanel\Resources\Pages;

use App\Filament\FrontPanel\Resources\WalkerResource;
use App\Http\Middleware\SetLocaleLanguage;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class InformationPage extends Page
{
    protected static ?string $navigationIcon = 'tabler-info-circle';
    //protected ?string $heading = 'Custom Page Heading';
    //protected ?string $subheading = 'Custom Page Subheading';

    protected static ?string $navigationGroup = 'Informations';
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

    public function getUrlCreate(): string
    {
        return WalkerResource::getUrl('create');
    }

    public function getView(): string
    {
        //dd($this->locale);
        return 'filament.pages.'.$this->locale.'.information';
    }

    public static function canAccess(): bool
    {
        return true;
    }

    public function getTitle(): string|Htmlable
    {
        return __('invoices::messages.page.information.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('invoices::messages.page.information.title');
    }
}
