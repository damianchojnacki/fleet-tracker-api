<?php

namespace App\Filament\Resources\CarResource\Pages;

use App\Filament\Resources\CarResource;
use App\Models\Organization;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreateCar extends CreateRecord
{
    protected static string $resource = CarResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        /** @var Organization $organization */
        $organization = Filament::getTenant();

        $data['organization_id'] = $organization->id;

        return $data;
    }
}
