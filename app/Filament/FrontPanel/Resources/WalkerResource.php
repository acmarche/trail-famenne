<?php

namespace App\Filament\FrontPanel\Resources;

use App\Filament\FrontPanel\Resources\WalkerResource\Pages;
use App\Form\WalkerForm;
use App\Models\Walker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WalkerResource extends Resource
{
    protected static ?string $model = Walker::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Inscription';

    public static function form(Form $form): Form
    {
        return WalkerForm::createForm($form);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([ ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([

            ]);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\CreateWalker::route('/'),
            'create' => Pages\CreateWalker::route('/create'),
            'complete' => Pages\RegistrationComplete::route('/{record}/complete'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('messages.registration.navigation.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('messages.registration.navigation.plural.model.label');
    }

}

//todo https://filamentphp.com/docs/3.x/panels/getting-started#casting-the-price-to-an-integer
