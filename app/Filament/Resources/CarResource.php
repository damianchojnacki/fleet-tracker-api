<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarResource\Pages;
use App\Filament\Resources\CarResource\Pages\CreateCar;
use App\Filament\Resources\CarResource\Pages\EditCar;
use App\Filament\Resources\CarResource\Pages\ListCars;
use App\Models\Car;
use App\Models\CarBrand;
use App\Models\Organization;
use App\Models\User;
use App\Services\CarRepository;
use Auth;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CarResource extends Resource
{
    protected static ?string $model = Car::class;

    protected static ?string $navigationIcon = 'fas-car';

    public static function form(Form $form): Form
    {
        /** @var User $user */
        $user = Auth::user();

        return $form
            ->schema([
                Select::make('organization_id')
                    ->relationship(name: 'organization', titleAttribute: 'name')
                    ->allowHtml()
                    ->getOptionLabelFromRecordUsing(fn (Organization $organization) =>
                        "<b>{$organization->id}</b> - {$organization->name}"
                    )
                    ->searchable(['name', 'id'])
                    ->default($user->organization->id)
                    ->required()
                    ->hidden(!$user->isAdmin())
                    ->preload(),
                Toggle::make('is_active')
                    ->default(true),
                TextInput::make('plate_number'),
                TextInput::make('vin'),
                Select::make('brand_id')
                    ->relationship(name: 'brand', titleAttribute: 'name')
                    ->searchable(['name'])
                    ->preload()
                    ->required(),
                TextInput::make('specs.year')
                    ->numeric()
                    ->step(1)
                    ->minValue(1900)
                    ->maxValue(date('Y')),
                Select::make('specs.model')
                    ->searchable()
                    ->searchDebounce(300)
                    ->getSearchResultsUsing(function (string $search, Get $get, CarRepository $repository) {
                        $year = $get('specs.year');
                        $brand = CarBrand::find((int) $get('brand_id'));

                        if(!$year || !$brand) {
                            return [$search => $search];
                        }

                        return $repository->models($brand->name, $year)
                            ->filter(function (string $model) use ($search) {
                                return str_contains(strtolower($model), strtolower($search));
                            })
                            ->push($search)
                            ->mapWithKeys(fn (string $model) => [$model => $model]);
                    })
                    ->native(false),
                Select::make('specs.transmission')
                    ->options([
                        'm' => __('Manual'),
                        'a' => __('Automatic'),
                    ])
                    ->native(false),
                Select::make('specs.fuel_type')
                    ->options([
                        'gas' => __('Gas'),
                        'diesel' => __('Automatic'),
                        'electricity' => __('Electricity'),
                        'hybrid' => __('Hybrid'),
                    ])
                    ->native(false),
                Select::make('specs.drive')
                    ->options([
                        'fwd' => __('FWD'),
                        'rwd' => __('RWD'),
                        'awd' => __('AWD'),
                    ])
                    ->native(false),
                TextInput::make('specs.fuel_consumption')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->step(0.1),
                TextInput::make('color'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('brand.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('specs')
                    ->sortable()
                    ->searchable(),
                IconColumn::make('is_active')
                    ->icon(fn (bool $state): string => match ($state) {
                        true => 'heroicon-o-check-circle',
                        default => 'heroicon-o-x-circle',
                    })
                    ->sortable()
                    ->disabled(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('brand')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload(),
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
            'index' => ListCars::route('/'),
            'create' => CreateCar::route('/create'),
            'edit' => EditCar::route('/{record}/edit'),
        ];
    }
}
