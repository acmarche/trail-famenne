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
     * todo
     */
    private function todo()
    {
        RegistrationProcessed::dispatch($record);
        Notification::make()
            ->success()
            ->title(__('messages.form.registration.notification.finish.title'))
            ->body(__('messages.form.registration.notification.finish.body'))
            ->send();

    }

    public function getTitle(): string|Htmlable
    {
        return __('messages.form.registration.actions.new.title');
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
     * For label
     */
    protected function getCreateFormAction(): Action
    {
        return Action::make('create')
            ->label(__('messages.form.registration.actions.create.label'))
            ->submit('create')
            ->keyBindings(['mod+s']);
    }

    public function getSubheading(): string
    {
        return __('messages.form.walker.actions.create.subheading');
    }

}
