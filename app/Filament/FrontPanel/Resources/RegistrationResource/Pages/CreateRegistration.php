<?php

namespace App\Filament\FrontPanel\Resources\RegistrationResource\Pages;

use App\Filament\FrontPanel\Resources\RegistrationResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateRegistration extends CreateRecord
{
    protected static string $resource = RegistrationResource::class;
    protected static bool $canCreateAnother = false;

    public function getTitle(): string|Htmlable
    {
        return __('messages.form.registration.actions.new.title');
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

    protected function getRedirectUrl(): string
    {
        $resource = static::getResource();

        if ($resource::hasPage('edit') && $resource::canEdit($this->getRecord())) {
            return $resource::getUrl('edit', ['record' => $this->getRecord(), ...$this->getRedirectUrlParameters()]);
        }

        if ($resource::hasPage('view') && $resource::canView($this->getRecord())) {
            return $resource::getUrl('view', ['record' => $this->getRecord(), ...$this->getRedirectUrlParameters()]);
        }

        return $resource::getUrl('index');
    }
}
