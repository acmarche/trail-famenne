<?php

namespace App\Filament\AdminPanel\Pages;

use App\Models\Walker;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Collection;

class PrintWalker extends Page
{
    protected static ?int $navigationSort = 5;
    /**
     * @var Collection|Walker[] $walkers
     */
    public Collection|array $walkers = [];

    public static function getNavigationLabel(): string
    {
        return 'Imprimer';
    }

    public static function getNavigationIcon(): string|Htmlable|null
    {
        return 'tabler-list';
    }

    protected static string $view = 'filament.pages.list-walkers';

    public function getLayout(): string
    {
        return static::$layout ?? 'filament-panels::components.layout.base';
    }

    public function __construct()
    {
        $this->walkers = Walker::query()->whereNotNull('payment_date')->orderBy('last_name')->get();
    }

}
