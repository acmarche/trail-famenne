<?php

namespace App\Filament\AdminPanel\Resources\RegistrationResource\Pages;

use App\Filament\AdminPanel\Resources\RegistrationResource;
use App\Models\Registration;
use Filament\Actions;
use Filament\Infolists;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewRegistration extends ViewRecord
{
    protected static string $resource = RegistrationResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Inscriptions '.$this->record->id;
    }

    protected function getHeaderActions(): array
    {
        return [
          //  Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('email')
                    ->label('Email souscripteur')
                    ->columnSpanFull(),
                Infolists\Components\TextEntry::make('is_paid')
                    ->label('Payé')
                    ->state(fn(Registration $registration) => $registration->isPaid() ? 'Oui' : 'Non')
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
