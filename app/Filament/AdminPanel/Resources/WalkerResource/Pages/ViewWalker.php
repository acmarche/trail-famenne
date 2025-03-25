<?php

namespace App\Filament\AdminPanel\Resources\WalkerResource\Pages;

use App\Filament\AdminPanel\Resources\WalkerResource;
use App\Models\Walker;
use Filament\Actions;
use Filament\Infolists;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewWalker extends ViewRecord
{
    protected static string $resource = WalkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Modifier')
                ->icon('tabler-edit'),
            Actions\DeleteAction::make()
                ->label('Supprimer')
                ->icon('tabler-trash'),
        ];
    }

    public function getTitle(): string
    {
        return $this->record->last_name.' '.$this->record->first_name ?? 'Empty name';
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Grid::make()
                    ->inlineLabel(true)
                    ->columns(2)
                    ->schema([
                        Fieldset::make('person')
                            ->label('Coordonnées')
                            ->schema([
                                Infolists\Components\TextEntry::make('email')
                                    ->icon('heroicon-m-envelope'),
                                Infolists\Components\TextEntry::make('phone')
                                    ->label('Téléphone')
                                    ->icon('heroicon-m-phone'),
                                Infolists\Components\TextEntry::make('city')
                                    ->label('Localité'),
                                Infolists\Components\TextEntry::make('date_of_birth')
                                    ->label('Né le')
                                    ->dateTime(),
                            ]),
                        Fieldset::make('contact')
                            ->label('Autres informations')
                            ->schema([
                                Infolists\Components\TextEntry::make('country')
                                    ->label('Pays'),
                                Infolists\Components\TextEntry::make('tshirt_size')
                                    ->label('T-shirt'),
                                Infolists\Components\TextEntry::make('club_name')
                                    ->label('Nom du club'),
                            ]),
                        Fieldset::make('rgpd')
                            ->label('Rgpd')
                            ->schema([
                                Infolists\Components\TextEntry::make('newsletter_accepted')
                                    ->label('Lettre d\'information'),
                                Infolists\Components\TextEntry::make('regulation_accepted')
                                    ->label('Accepte le règlement'),
                                Infolists\Components\TextEntry::make('registration_date')
                                    ->label('Date d\'inscription')
                                    ->dateTime(),
                                Infolists\Components\TextEntry::make('is_paid')
                                    ->label('Payé')
                                    ->state(fn(Walker $walker) => $walker->isPaid() ? 'Oui' : 'Non')
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
