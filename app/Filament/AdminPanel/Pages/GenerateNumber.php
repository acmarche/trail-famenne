<?php

namespace App\Filament\AdminPanel\Pages;

use App\Models\Role;
use App\Models\Walker;
use App\Utils\RegistrationUtils;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class GenerateNumber extends Page implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $title = 'Numérotation des marcheurs';
    protected static ?string $navigationGroup = 'Administration';
    protected static ?string $navigationIcon = 'tabler-shirt-sport';
    protected static string $view = 'filament.pages.tshirts';

    public function getSubheading(): string|Htmlable|null
    {
        return 'La numérotation se fait par ordre de date d\'inscription';
    }

    /**
     * Necessary for group by
     * @param Model $record
     * @return string
     */
    public function getTableRecordKey(Model $record): string
    {
        return (string)$record->id;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Walker::canHaveTshirts())
            ->columns([
                TextColumn::make('last_name')
                    ->label('Nom'),
                TextColumn::make('first_name')
                    ->label('Prénom'),
                TextColumn::make('tshirt_number')
                    ->label('Numéro de T-shirt'),
            ])
            ->headerActions([
                Action::make('generate')
                    ->label('Générer les numéros')
                    ->requiresConfirmation()
                    ->action(function () {
                        foreach (Walker::withOutNumberTshirt()->get() as $walker) {
                            RegistrationUtils::generateNumber($walker);
                            $walker->save();
                        }
                        Notification::make()
                            ->title('Numéros générés')
                            ->success()
                            ->send();
                        $this->redirect(request()->header('referer'));
                    }),
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
