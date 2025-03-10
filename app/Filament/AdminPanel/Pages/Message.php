<?php

namespace App\Filament\AdminPanel\Pages;

use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Message extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $title = 'Contact';
    protected static ?string $navigationGroup = 'Administration';
    protected static ?string $navigationIcon = 'tabler-message';
    protected static string $view = 'filament.pages.contact';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('subject')
                    ->label('Sujet')
                    ->required()
                    ->maxLength(150),
                Forms\Components\Textarea::make('content')
                    ->label('Message')
                    ->required()
                    ->rows(7)
                    ->minLength(50),
                Forms\Components\Actions::make([
                    Action::make('send')
                        ->label('Envoyer')
                        ->requiresConfirmation()
                        ->action(function () {
                            Notification::make()
                                ->title('Message envoyé')
                                ->success()
                                ->send();
                        }),
                ]),
            ]);
    }

    public function getLayout(): string
    {
        return static::$layout ?? 'filament-panels::components.layout.index';
    }

    public static function canAccess(): bool
    {
        $isAdmin = auth()->user()?->hasRole(Role::ROLE_ADMIN);

        return $isAdmin ?? false;
    }
}
