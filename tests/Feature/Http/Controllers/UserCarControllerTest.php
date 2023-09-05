<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Car;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UserCarController
 */
class UserCarControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function testUpdatesUserCar(): void
    {
        $organization = Organization::factory()->create();

        $user = User::factory()->create([
            'organization_id' => $organization->id,
        ]);

        $car = Car::factory()->recycle($organization)->create();

        $this->actingAs($user)
            ->putJson(route('user.cars.update', [
                'car' => $car,
            ]))
            ->assertSuccessful();

        $user->refresh();

        $this->assertEquals($car->id, $user->car->id);
    }
}
