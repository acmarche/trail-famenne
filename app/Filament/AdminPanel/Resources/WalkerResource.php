<?php

namespace App\Filament\AdminPanel\Resources;

use App\Constant\TshirtEnum;
use App\Events\RegistrationProcessed;
use App\Filament\Actions\InvoiceDownloadAction;
use App\Filament\AdminPanel\Resources\WalkerResource\Pages;
use App\Form\WalkerForm;
use App\Models\Role;
use App\Models\Walker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Filament\FrontPanel\Resources\WalkerResource as FrontWalker;

class WalkerResource extends Resource
{
    protected static ?string $model = Walker::class;

    protected static ?string $navigationIcon = 'tabler-walk';

    public static function getNavigationLabel(): string
    {
        return 'Marcheurs';
    }

    public static function getModelLabel(): string
    {
        return 'Marcheurs';
    }

    public static function form(Form $form): Form
    {
        return WalkerForm::createForm($form);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(50)
            ->columns([
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tshirt_size')
                    ->label('T-shirt')
                    ->badge()->size('xxl')
                    ->color(fn(TshirtEnum $state): string => $state->getColor())
                    ->icon(fn(TshirtEnum $state): string => $state->getIcon()),

                Tables\Columns\IconColumn::make('newsletter_accepted')
                    ->boolean(),
                Tables\Columns\TextColumn::make('is_paid')
                    ->label('Payé')
                    ->state(fn(Walker $walker) => $walker->isPaid() ? 'Oui' : 'Non'),
                Tables\Columns\TextColumn::make('registration_date')
                    ->label('Date d\'inscription')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('registration.id')
                    ->label('Date d\'inscription')
                    ->formatStateUsing(fn ($record) => $record->registration->registrationDateFormated())
                    ->url(
                        fn($record)
                            => FrontWalker::getUrl(
                            name: 'complete',
                            parameters: ['record' => $record->registration_id],
                            panel: 'front',
                        ),
                    )->openUrlInNewTab()
                ,
                /*->state(function ( $state) {
                    dd($state);
                    return $state;
                }),*/
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
            ])
            ->filters([
                Filter::make('is_paid')
                    ->query(fn(Builder $query) => $query->where('payment_date', 'IS NOT', null)),
            ])
            ->actions([
                Tables\Actions\Action::make('payment')
                    ->action(function (Walker $record) {
                        $record->payment_date = new \DateTime();
                        $record->save();
                        Notification::make()
                            ->title('Facture payée')
                            ->success()
                            ->send();
                        RegistrationProcessed::dispatch($record);
                    })
                    ->label(fn(Walker $record): string => $record->isPaid() ? 'Payé' : 'Payer')
                    ->tooltip(fn(Walker $record): string => $record->isPaid() ? '' : 'Payer')
                    ->disabled(fn(Walker $record): bool => $record->isPaid())
                    ->form(function (Form $form) {
                        return $form->schema([
                            Forms\Components\DatePicker::make('payment_date')
                                ->label('Date de paiment')
                                ->default(now())
                                ->required(),
                        ]);
                    })
                    ->requiresConfirmation()
                    ->icon('tabler-tax-euro')
                    ->modalIcon('tabler-pig-money')
                    ->color(
                        fn(Walker $walker): string => $walker->isPaid() ? 'success' : 'danger',
                    )
                    ->modalIconColor(
                        fn(Walker $walker): string => $walker->isPaid() ? 'success' : 'warning',
                    )
                    ->modalHeading(__('Payer la facture'))
                    ->modalDescription(__('Confirmer que la facture a été payée.')),
                Tables\Actions\ViewAction::make()->label('Visualiser'),
                Tables\Actions\EditAction::make(),
                InvoiceDownloadAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWalkers::route('/'),
            'create' => Pages\CreateWalker::route('/create'),
            'view' => Pages\ViewWalker::route('/{record}'),
            'edit' => Pages\EditWalker::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return Auth::getUser()->hasRole(Role::ROLE_ADMIN);
    }
}
