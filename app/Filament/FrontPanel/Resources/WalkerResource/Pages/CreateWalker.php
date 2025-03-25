<?php

namespace App\Filament\FrontPanel\Resources\WalkerResource\Pages;

use App\Events\RegistrationProcessed;
use App\Filament\FrontPanel\Resources\WalkerResource;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateWalker extends CreateRecord
{
    protected static string $resource = WalkerResource::class;
    protected static bool $canCreateAnother = false;

    /**
     * todo use hookcallHook('afterCreate')
     */
    protected function afterCreate(): void
    {
        RegistrationProcessed::dispatch($this->record);
        Notification::make()
            ->success()
            ->title(__('invoices::messages.form.registration.notification.finish.title'))
            ->body(__('invoices::messages.form.registration.notification.finish.body'))
            ->send();
    }

    public function getTitle(): string|Htmlable
    {
        return __('invoices::messages.form.registration.actions.new.title');
    }

    protected function getRedirectUrl(): string
    {
        $resource = static::getResource();

        if ($resource::hasPage('complete') && $resource::canView($this->getRecord())) {
            return $resource::getUrl('complete', ['record' => $this->getRecord()]);
        }

        return $resource::getUrl('index');
    }

    /**
     * Remove btn confirm
     * @return array|Action[]|\Filament\Actions\ActionGroup[]
     */
    public function getFormActions(): array
    {
        return [];
    }

    public function getSubheading(): string
    {
        return __('invoices::messages.form.walker.actions.create.subheading');
    }

}
