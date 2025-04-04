<?php

namespace App\Providers;

use App\Invoice\Invoice;
use App\Invoice\QrCode\QrCodeGenerator;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('qrCodeGenerator', function ($app) {
            return new QrCodeGenerator();
        });
        $this->app->singleton('invoice', function ($app) {
            return new Invoice();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views/invoices', 'invoices');
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'invoices');

        if (!app()->environment('production')) {
            Mail::alwaysTo('jf@marche.be');
        }

        TextInput::configureUsing(function (TextInput $config) {
            $config->inlineLabel();
        });
        Select::configureUsing(function (Select $config) {
            $config->inlineLabel();
        });
        DatePicker::configureUsing(function (DatePicker $config) {
            $config->inlineLabel();
        });
        Section::configureUsing(function (Section $config) {
            $config
                ->columns()
                ->compact();
        });
        FilamentAsset::register([
            Js::make('trail-js', __DIR__ . '/../../resources/js/trail.js'),
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['qrCodeGenerator'];
    }
}
