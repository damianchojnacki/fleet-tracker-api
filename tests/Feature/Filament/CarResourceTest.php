<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\CarResource;
use App\Filament\Resources\CarResource\Pages\CreateCar;
use App\Filament\Resources\CarResource\Pages\EditCar;
use App\Filament\Resources\CarResource\Pages\ListCars;
use App\Models\Car;
use Filament\Actions\DeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

/**
 * @see \App\Filament\Resources\CarResource
 */
class CarResourceTest extends FilamentTestCase
{
    use RefreshDatabase;

    public function testRendersListPage()
    {
        $this->actingAs($this->user)
            ->get(CarResource::getUrl('index'))
            ->assertSuccessful();
    }

    public function testRendersCreatePage()
    {
        $this->actingAs($this->user)
            ->get(CarResource::getUrl('create'))
            ->assertSuccessful();
    }

    public function testRendersUpdatePage()
    {
        $car = Car::factory()
            ->recycle(
                $this->user->organization
            )
            ->create();

        $this->actingAs($this->user)
            ->get(CarResource::getUrl('edit', [
                'record' => $car,
            ]))
            ->assertSuccessful();
    }

    public function testListsCorrectCars()
    {
        $cars = Car::factory()
            ->recycle(
                $this->user->organization
            )
            ->count(3)
            ->create();

        $hidden = Car::factory()
            ->count(3)
            ->create();

        Livewire::test(ListCars::class)
            ->assertCanSeeTableRecords($cars)
            ->assertCanNotSeeTableRecords($hidden);
    }

    public function testCreatesCar()
    {
        $data = Car::factory()->make()->toArray();

        Livewire::test(CreateCar::class)
            ->fillForm($data)
            ->call('create')
            ->assertHasNoFormErrors();

        $car = Car::firstWhere('specs->plate_number', $data['specs']['plate_number']);

        $this->assertNotNull($car);

        $this->assertEquals($data['brand_id'], $car->brand->id);
        $this->assertEquals($data['specs'], $car->specs);
        $this->assertEquals($data['mileage'], $car->mileage);
        $this->assertEquals($data['is_active'], $car->is_active);
    }

    public function testUpdatesCar()
    {
        $car = Car::factory()
            ->recycle(
                $this->user->organization
            )
            ->create();

        $data = Car::factory()
            ->make()
            ->toArray();

        Livewire::test(EditCar::class, [
            'record' => $car->id,
        ])->fillForm($data)
            ->call('save')
            ->assertHasNoFormErrors();

        $car = $car->fresh();

        $this->assertEquals($data['brand_id'], $car->brand->id);
        $this->assertEquals($data['specs'], $car->specs);
        $this->assertEquals($data['mileage'], $car->mileage);
        $this->assertEquals($data['is_active'], $car->is_active);
    }

    public function testDeletesCar()
    {
        $car = Car::factory()
            ->recycle(
                $this->user->organization
            )
            ->create();

        Livewire::test(EditCar::class, [
            'record' => $car->id,
        ])->callAction(DeleteAction::class);

        $this->assertModelMissing($car);
    }
}
