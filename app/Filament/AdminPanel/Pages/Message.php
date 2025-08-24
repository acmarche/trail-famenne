<?php

namespace App\Filament\AdminPanel\Pages;

use App\Mail\ContactMessage;
use App\Models\Role;
use App\Models\Walker;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Address;

class Message extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $title = 'Contact';
    protected static ?string $navigationGroup = 'Administration';
    protected static ?string $navigationIcon = 'tabler-message';
    protected static string $view = 'filament.pages.contact';

    //public array $formData = [];
    public string $body = '';
    public string $subject = '';
    public bool $everyone = false;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('subject')
                    ->label('Sujet')
                    ->required()
                    ->maxLength(150),
                Forms\Components\RichEditor::make('body')
                    ->label('Message')
                    ->required()
                    ->minLength(50),
                Forms\Components\Checkbox::make('everyone')
                    ->label('Envoyer à tous les participants')
                    ->helperText('En cochant la case, ceux qui n\'ont pas encore payé recevront aussi le mail'),
                Forms\Components\Actions::make([
                    Action::make('send')
                        ->label('Envoyer')
                        ->requiresConfirmation()
                        ->action(function (array $data) {
                            $this->sendMessage($this->subject, $this->body, $this->everyone);
                            Notification::make()
                                ->title('Message envoyé')
                                ->success()
                                ->send();
                            $this->body = '';
                            $this->subject = '';
                        })
                        ->successRedirectUrl($this::getUrl()),
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

    private function sendMessage(string $subject, string $message, bool $everyone): void
    {
        if ($everyone) {
            $emails = Walker::query()->get()
                ->pluck('email');
        } else {
            $emails = Walker::whereNotNull('payment_date')
                ->distinct()
                ->pluck('email');
        }
        foreach ($emails as $email) {
            try {
                Mail::to(new Address($email, $email))
                    ->send(
                        (new ContactMessage($message))
                            ->subject($subject)
                    );
            } catch (\Exception $e) {
                Notification::make()
                    ->title('Message non envoyé')
                    ->body('Pour le mail '.$email)
                    ->danger()
                    ->send();
            }
            break;
        }
    }
}
