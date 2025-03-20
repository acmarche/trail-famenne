<?php

namespace App\Filament\FrontPanel\Resources\WalkerResource\Pages;

use App\Filament\FrontPanel\Resources\WalkerResource;
use Filament\Resources\Pages\ListRecords;

class ListWalkers extends ListRecords
{
    protected static string $resource = WalkerResource::class;

    protected static string $view = 'filament.resources.registrations-list';

    public function urlNew(): string
    {
        return WalkerResource::getUrl('create');
    }

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
