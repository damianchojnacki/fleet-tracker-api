<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CarController
 */
class CarControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function shouldListCars(): void
    {
        Car::factory()->count(3)->create();

        $response = $this->getJson(route('cars.index'))
            ->assertSuccessful();

        $this->assertNotNull($response->json());
        $this->assertCount(3, $response->json());
    }


    /**
     * @test
     */
    public function shouldShowCar(): void
    {
        $car = Car::factory()->create();

        $response = $this->getJson(route('cars.show', $car))
            ->assertSuccessful();

        $this->assertNotNull($response->json());
        $this->assertEquals($car->id, $response->json('id'));
    }
}
