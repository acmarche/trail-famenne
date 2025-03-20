<?php

namespace App\Form;

use App\Constant\TshirtEnum;
use App\Filament\FrontPanel\Resources\Pages\InformationPage;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Illuminate\Support\HtmlString;

class WalkerForm
{
    public static function createForm(Form $form): Form
    {
        return $form
            ->live()
            ->columns(1)
            ->schema([
                Wizard::make([
                    Wizard\Step::make('necessary_data')
                        ->label(__('invoices::messages.form.registration.walkers.step1.label'))
                        ->schema(
                            self::fieldsPersonal(),
                        ),
                    Wizard\Step::make('contact')
                        ->label(__('invoices::messages.form.registration.walkers.step2.label'))
                        ->schema(
                            self::fieldsContact(),
                        ),
                    Wizard\Step::make('dgpr')
                        ->label(__('invoices::messages.form.registration.walkers.step3.label'))
                        ->schema(
                            self::fieldsGdpr(),
                        ),
                ])
                    ->nextAction(
                        fn(Action $action) => $action->label(
                            __('invoices::messages.form.registration.actions.next.label')
                        )->color('success'),
                    )->previousAction(
                        fn(Action $action) => $action->label(
                            __('invoices::messages.form.registration.actions.previous.label')
                        )->color('warning'),
                    )
                    ->submitAction(view('filament.front-panel.resources.bnt_add_walker')),
            ]);

    }

    private static function fieldsPersonal(): array
    {
        return [
            TextInput::make('first_name')
                ->label(__('invoices::messages.first_name'))
                ->required()
                ->maxLength(150),
            TextInput::make('last_name')
                ->label(__('invoices::messages.last_name'))
                ->required()
                ->maxLength(150),
            TextInput::make('email')
                ->label(__('invoices::messages.email'))
                ->email()
                ->suffixIcon('tabler-mail')
                ->maxLength(150)
                ->autocomplete('email')
                ->required(),
            TextInput::make('phone')
                ->label(__('invoices::messages.phone'))
                ->required()
                ->tel(),
            DatePicker::make('date_of_birth')
                ->label(__('invoices::messages.date_of_birth.label'))
                ->helperText(__('invoices::messages.date_of_birth.help'))
                ->required()
                ->maxDate(now())
                ->date(),
            Select::make('tshirt_size')
                ->label(__('invoices::messages.tshirt_size'))
                ->helperText(__('invoices::messages.tshirt.help'))
                ->default(TshirtEnum::NO->value)
                ->options(TshirtEnum::class)
                ->suffixIcon('tabler-shirt-sport'),
        ];
    }

    private static function fieldsContact(): array
    {
        return [
            TextInput::make('city')
                ->label(__('invoices::messages.city'))
                ->maxLength(150),
            TextInput::make('country')
                ->label(__('invoices::messages.country'))
                ->maxLength(150),
        ];
    }

    private static function fieldsGdpr(): array
    {
        $url = InformationPage::getUrl();

        return [
            Checkbox::make('newsletter_accepted')
                ->label(__('messages.form.registration.actions.newsletter_accepted.label'))
                ->required(false),
            Checkbox::make('gdpr_accepted')
                ->required()
                ->label(__('messages.form.registration.actions.gdpr_accepted.label')),
            Checkbox::make('regulation_accepted')
                ->required()
                ->label(__('messages.form.registration.actions.regulation_accepted.label')),
            Placeholder::make('documentation')
                ->label(__('invoices::messages.documentation'))
                ->content(new HtmlString('<a href="'.$url.'">Reglement</a>')),
            Checkbox::make('display_name')
                ->label(__('invoices::messages.display_name')),
        ];
    }

}
