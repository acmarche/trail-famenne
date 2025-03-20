<?php

namespace App\Filament\AdminPanel\Resources\WalkerResource\Pages;

use App\Filament\AdminPanel\Resources\WalkerResource;

use Filament\Actions;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewWalker extends ViewRecord
{
    protected static string $resource = WalkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist2(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('email')
                    ->label('Email souscripteur')
                    ->columnSpanFull(),
                Infolists\Components\TextEntry::make('is_paid')
                    ->label('Payé')
                    ->state(fn(Walker $walker) => $walker->isPaid() ? 'Oui' : 'Non')
                    ->columnSpanFull(),
                RepeatableEntry::make('walkers')
                    ->label('Marcheurs')
                    ->schema([
                        Infolists\Components\Grid::make()
                            ->inlineLabel(true)
                            ->columns(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('first_name')
                                    ->label('Prénom'),
                                Infolists\Components\TextEntry::make('last_name')
                                    ->label('Nom'),
                                Infolists\Components\TextEntry::make('email')
                                    ->icon('heroicon-m-envelope'),
                                Infolists\Components\TextEntry::make('phone')
                                    ->label('Téléphone')
                                    ->icon('heroicon-m-phone'),
                                Infolists\Components\TextEntry::make('street')
                                    ->label('Rue'),
                                Infolists\Components\TextEntry::make('city')
                                    ->label('Localité'),
                                Infolists\Components\TextEntry::make('country')
                                    ->label('Pays'),
                                Infolists\Components\TextEntry::make('tshirt_size')
                                    ->label('T-shirt'),
                                Infolists\Components\TextEntry::make('date_of_birth')
                                    ->label('Né le')
                                    ->dateTime(),
                                Infolists\Components\TextEntry::make('club_name')
                                    ->label('Nom du club'),
                            ]),
                    ]),
            ]);
    }
}
