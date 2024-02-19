<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\Car;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Drivers';

    protected static ?string $navigationIcon = 'fas-users';

    public static function form(Form $form): Form
    {
        /** @var User $user */
        $user = Auth::user();

        return $form
            ->schema([
                TextInput::make('firstname')
                    ->required(),
                TextInput::make('lastname')
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->minLength(8)
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create'),
                Toggle::make('email_verified_at')
                    ->hidden(! $user->isAdmin())
                    ->label('Email Verified')
                    ->dehydrateStateUsing(fn (?string $state): ?Carbon => filled($state) ? now() : null),
                Select::make('car_id')
                    ->label('Car')
                    ->options($user->organization->cars()->with('brand')->get()->mapWithKeys(fn($car) => [
                        $car->id => "{$car->brand->name} {$car->specs['model']} {$car->specs['year']}"
                    ]))
                    ->searchable()
            ]);
    }

    public static function table(Table $table): Table
    {
        /** @var User $user */
        $user = Auth::user();

        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('firstname')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('lastname')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email_verified_at')
                    ->hidden(! $user->isAdmin())
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
                ToggleColumn::make('is_admin')
                    ->label('Admin')
                    ->hidden(! $user->isAdmin())
                    ->sortable()
                    ->disabled(),
                TextColumn::make('car')
                    ->formatStateUsing(fn (?Car $state): string => $state ? "{$state->brand?->name} {$state->specs['model']} {$state->specs['year']}" : ''),
            ])
            ->filters([
                Filter::make('is_admin')
                    ->hidden(! $user->isAdmin())
                    ->toggle()
                    ->query(fn (Builder $query) => $query->where('is_admin', true))
                    ->label('Admin'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                CreateAction::make(),
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
