<?php

namespace App\Form;

use App\Constant\SexEnum;
use App\Constant\TshirtEnum;
use App\Filament\FrontPanel\Resources\Pages\InformationPage;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
                Section::make(__('invoices::messages.form.registration.walkers.step1.label'))
                    ->schema(
                        self::fieldsPersonal(),
                    ),
                Section::make(__('invoices::messages.form.registration.walkers.step2.label'))
                    ->schema(
                        self::fieldsContact(),
                    ),
                Section::make(__('invoices::messages.form.registration.walkers.step3.label'))
                    ->schema(
                        self::fieldsGdpr(),
                    ),
            ]);
    }

    private static function fieldsPersonal(): array
    {
        return [
            Grid::make('personal')
                ->columns(
                    [
                        'sm' => 1,
                        'md' => 2,
                        'lg' => 2,
                        'xl' => 2,
                    ]
                )
                ->schema([
                    TextInput::make('last_name')
                        ->label(__('invoices::messages.last_name'))
                        ->required()
                        ->maxLength(150),
                    TextInput::make('first_name')
                        ->label(__('invoices::messages.first_name'))
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
                    Select::make('tshirt_size')
                        ->label(__('invoices::messages.tshirt_size.label'))
                        ->helperText(__('invoices::messages.tshirt_size.help'))
                        // ->default(TshirtEnum::NO->value)
                        ->required()
                        ->options(TshirtEnum::class)
                        ->suffixIcon('tabler-shirt-sport'),
                    Select::make('tshirt_sex')
                        ->label(__('invoices::messages.tshirt_sex.label'))
                        ->helperText(__('invoices::messages.tshirt_sex.help'))
                        ->placeholder('')
                        ->required()
                        ->options(SexEnum::class)
                        ->suffixIcon('tabler-gender-hermaphrodite'),
                ]),
        ];
    }

    private static function fieldsContact(): array
    {
        return [
            Grid::make('contact')
                ->columns(
                    [
                        'sm' => 1,
                        'md' => 2,
                        'lg' => 2,
                        'xl' => 2,
                    ]
                )
                ->schema([
                    DatePicker::make('date_of_birth')
                        ->label(__('invoices::messages.date_of_birth.label'))
                        ->helperText(__('invoices::messages.date_of_birth.help'))
                        ->required()
                        ->maxDate(now())
                        ->date(),
                    TextInput::make('club_name')
                        ->label(__('invoices::messages.club_name'))
                        ->maxLength(150),
                    TextInput::make('city')
                        ->label(__('invoices::messages.city'))
                        ->maxLength(150),
                    TextInput::make('country')
                        ->label(__('invoices::messages.country'))
                        ->maxLength(150),
                ]),
        ];
    }

    private static function fieldsGdpr(): array
    {
        $url = InformationPage::getUrl(panel: 'front');
        $labelRegulation = __('invoices::messages.regulation.label');

        return [
            Checkbox::make('newsletter_accepted')
                ->label(__('invoices::messages.form.registration.actions.newsletter_accepted.label'))
                ->required(false),
            Checkbox::make('gdpr_accepted')
                ->required()
                ->label(__('invoices::messages.form.registration.actions.gdpr_accepted.label')),
            Checkbox::make('regulation_accepted')
                ->required()
                ->label(__('invoices::messages.form.registration.actions.regulation_accepted.label')),
            Placeholder::make('documentation')
                ->label(__('invoices::messages.documentation'))
                ->content(new HtmlString('<a href="'.$url.'" target="_blank">'.$labelRegulation.'</a>')),
            Checkbox::make('display_accepted')
                ->label(__('invoices::messages.display_name')),
        ];
    }

}
