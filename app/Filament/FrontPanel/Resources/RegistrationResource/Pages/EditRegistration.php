<?php

namespace App\Filament\FrontPanel\Resources\RegistrationResource\Pages;

use App\Events\RegistrationProcessed;
use App\Filament\FrontPanel\Resources\RegistrationResource;
use App\Filament\FrontPanel\Resources\RegistrationResource\RelationManagers\WalkersRelationManager;
use App\Models\Registration;
use App\Models\Walker;
use Filament\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\MaxWidth;
use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\Support\Htmlable;

class EditRegistration extends EditRecord
{
    protected static string $resource = RegistrationResource::class;
    protected ?bool $hasUnsavedDataChangesAlert = true;//todo
   // public $defaultAction = 'launchForm';

    public function launchForm(): Actions\Action
    {
       // $this->dispatch('mountTableAction', action: 'create');

        /**
         * @var Registration $registration
         */
        $registration = $this->getRecord();

        return Actions\CreateAction::make('lauchForm')
            ->model(Walker::class)
            ->modalHeading(__('invoices::messages.form.walker.actions.create.label'))
            ->visible(fn() => $registration->walkers->count() < 1)
            ->action(function (array $data) use ($registration): void {
                $data['registration_id'] = $registration->id;
                Walker::create($data);
                $this->dispatch('refreshTable');

                return;
                /*  $this->getSavedNotification()?->send();
                  $this->sendSuccessNotification();
                  $this->getSavedNotification();*/
                //$livewire->mountedTableActionRecord($registration->getKey());
            })
            ->after(fn() => $this->dispatch('refreshTable'))
            ->modalSubmitAction(false)
            ->createAnother(false)
            ->form(function (Form $form) use ($registration): Form {
                return WalkersRelationManager::createForm($form, $registration);
            });
    }

    public static function canAccess(array $parameters = []): bool
    {
        $record = $parameters['record'] ?? null;
        if ($record instanceof Registration) {
            if ($record->isCompleted()) {
                Notification::make()
                    ->danger()
                    ->title('Registration is completed')
                    ->body('You cannot edit it.')
                    ->send();
            }

            return !$record->isCompleted();
        }

        return false;
    }

    public function getTitle(): string|Htmlable
    {
        return __('messages.form.registration.actions.edit.title');
    }

    public function getSubheading(): string
    {
        return __('messages.form.registration.actions.edit.subheading');
    }

    public function getFormActions(): array
    {
        return [
            Actions\Action::make('completed')
                ->form([
                    Checkbox::make('newsletter_accepted')
                        ->label(__('messages.form.registration.actions.newsletter_accepted.label'))
                        ->required(false),
                    Checkbox::make('gdpr_accepted')
                        ->required()
                        ->label(__('messages.form.registration.actions.gdpr_accepted.label')),
                    Checkbox::make('regulation_accepted')
                        ->required()
                        ->label(__('messages.form.registration.actions.regulation_accepted.label')),
                ])
                ->label(__('messages.form.registration.actions.header.finish.label'))
                ->requiresConfirmation()
                ->modalIcon('heroicon-o-check')
                ->color('success')
                ->modalIconColor('warning')
                ->modalHeading(__('messages.form.registration.actions.modal.finish.title'))
                ->modalDescription(__('messages.form.registration.actions.modal.finish.description'))
                ->modalSubmitActionLabel(__('messages.form.registration.actions.modal.finish.label'))
                ->modalWidth(MaxWidth::ExtraLarge)
                ->action(function (array $data, Registration $record): void {
                    if ($record->walkers->count() === 0) {
                        Notification::make()
                            ->danger()
                            ->title(__('messages.form.registration.notification.nowalkers.title'))
                            ->body(__('messages.form.registration.notification.nowalkers.body'))
                            ->send();

                        return;
                    }

                    $this->saveRegistration($data, $record);

                    Notification::make()
                        ->success()
                        ->title(__('messages.form.registration.notification.finish.title'))
                        ->body(__('messages.form.registration.notification.finish.body'))
                        ->send();

                    $this->getSavedNotification()?->send();
                    $redirectUrl = $this->getRedirectUrl();

                    $this->redirect($redirectUrl, navigate: FilamentView::hasSpaMode() && is_app_url($redirectUrl));
                }),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    /**
     * @param array $data
     * @param Registration $record
     * @return void
     */
    private function saveRegistration(array $data, Registration $record): void
    {
        $record->gdpr_accepted = $data['gdpr_accepted'] ?? false;
        $record->newsletter_accepted = $data['newsletter_accepted'] ?? false;
        $record->setCompleted();
        $record->save();

        RegistrationProcessed::dispatch($record);
    }

    protected function hasUnsavedDataChangesAlert22(): bool
    {
        return $this->record;//todo condition
    }

    protected function getRedirectUrl(): ?string
    {
        $resource = static::getResource();

        if ($resource::hasPage('complete') && $resource::canView($this->getRecord())) {
            return $resource::getUrl('complete', ['record' => $this->getRecord()]);
        }

        return null;
    }
}
