<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
    public function shouldUpdateUserCar(): void
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $this->actingAs($user)
            ->putJson(route('user.cars.update', [
                'car' => $car,
            ]))
            ->assertSuccessful();

        $user->refresh();

        $this->assertEquals($car->id, $user->car->id);
    }
}
