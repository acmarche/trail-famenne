<?php

namespace App\Filament\AdminPanel\Resources\WalkerResource\Pages;

use App\Filament\AdminPanel\Resources\WalkerResource;
use App\Utils\RegistrationUtils;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateWalker extends CreateRecord
{
    protected static string $resource = WalkerResource::class;
    protected static ?string $title = 'Ajouter un marcheur';

    protected function afterCreate(): void
    {
        try {
            RegistrationUtils::generateNumber($this->record);
            $this->record->save();
        } catch (\Exception $exception) {
            Notification::make()
                ->title('Numéro de T-shirt non attribué')
                ->danger()
                ->send();
        }
    }
}
