<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Car;
use App\Models\Organization;
use App\Models\User;
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
    public function testListsCars(): void
    {
        $organization = Organization::factory()->create();

        $user = User::factory()->create([
            'organization_id' => $organization->id,
        ]);

        Car::factory()->recycle($organization)->count(3)->create();

        $response = $this->actingAs($user)
            ->getJson(route('cars.index'))
            ->assertSuccessful();

        $this->assertNotNull($response->json());
        $this->assertCount(3, $response->json());
    }


    /**
     * @test
     */
    public function testShowsCar(): void
    {
        $organization = Organization::factory()->create();

        $user = User::factory()->create([
            'organization_id' => $organization->id,
        ]);

        $car = Car::factory()->recycle($organization)->create();

        $response = $this->actingAs($user)
            ->getJson(route('cars.show', $car))
            ->assertSuccessful();

        $this->assertNotNull($response->json());
        $this->assertEquals($car->id, $response->json('id'));
    }
}
