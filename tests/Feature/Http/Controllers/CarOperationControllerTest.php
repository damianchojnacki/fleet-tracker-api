<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Car;
use App\Models\CarOperation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CarOperationController
 */
class CarOperationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanListCarOperations(): void
    {
        CarOperation::factory()
            ->count(3)
            ->create();

        $car = Car::factory()->create();

        $user = User::factory()->create([
            'organization_id' => $car->organization_id,
            'car_id' => $car->id,
        ]);

        CarOperation::factory()
            ->count(3)
            ->recycle($car)
            ->recycle($user)
            ->create();

        $response = $this->actingAs($user)
            ->getJson(route('cars.operations.index', ['car' => $car->id]))
            ->assertSuccessful();

        $this->assertNotNull($response->json());
        $this->assertCount(3, $response->json());
    }

    public function testUserCanCreateCarOperation(): void
    {
        $car = Car::factory()->create();

        $user = User::factory()->create([
            'organization_id' => $car->organization_id,
            'car_id' => $car->id,
        ]);

        $body = CarOperation::factory()->make();

        $response = $this->actingAs($user)
            ->postJson(route('cars.operations.store', ['car' => $car->id]), $body->toArray())
            ->assertSuccessful();

        $operation = CarOperation::find($response->json('id'));

        $this->assertNotNull($operation);
        $this->assertEquals($car->id, $operation->car->id);
        $this->assertEquals($user->id, $operation->user->id);
        $this->assertEquals($body->cost, $operation->cost);
        $this->assertEquals($body->note, $operation->note);
        $this->assertEquals($body->type, $operation->type);
    }

    public function testUserCanNotCreateCarOperationToCarThatDoesNotBelongs(): void
    {
        $car = Car::factory()->create();

        $user = User::factory()->create([
            'car_id' => null,
        ]);

        $this->actingAs($user)
            ->postJson(route('cars.operations.store', ['car' => $car]), [
                'car_id' => $car->id,
            ])
            ->assertForbidden();
    }

    public function testUserCanUpdateCarOperation(): void
    {
        $car = Car::factory()->create();

        $user = User::factory()->create([
            'organization_id' => $car->organization_id,
        ]);

        $operation = CarOperation::factory()
            ->recycle($car)
            ->recycle($user)
            ->create();

        $body = CarOperation::factory()->make();

        $this->actingAs($user)
            ->putJson(route('cars.operations.update', [
                'car' => $car,
                'operation' => $operation]
            ), $body->toArray())
            ->assertSuccessful();

        $operation = $operation->fresh();

        $this->assertEquals($user->id, $operation->user->id);
        $this->assertEquals($car->id, $operation->car->id);
        $this->assertEquals($body->note, $operation->note);
        $this->assertEquals($body->distance, $operation->distance);
        $this->assertEquals($body->type, $operation->type);
    }

    public function testUserCanNotUpdateCarOperationThatDoesNotBelongs(): void
    {
        $operation = CarOperation::factory()->create();

        $car = Car::factory()->create();

        $user = User::factory()->create([
            'organization_id' => $car->organization_id,
        ]);

        $body = CarOperation::factory()->make();

        $this->actingAs($user)
            ->putJson(route('cars.operations.update', [
                'car' => $car,
                'operation' => $operation
            ]), $body->toArray())
            ->assertForbidden();
    }

    public function testUserCanDeleteCarOperation(): void
    {
        $car = Car::factory()->create();

        $user = User::factory()->create([
            'organization_id' => $car->organization_id,
        ]);

        $operation = CarOperation::factory()
            ->recycle($car)
            ->recycle($user)
            ->create();

        $this->actingAs($user)
            ->deleteJson(route('cars.operations.destroy', [
                'car' => $car,
                'operation' => $operation
            ]))->assertSuccessful();

        // Ensure the trip is deleted from the database
        $this->assertModelMissing($operation);
    }

    public function testUserCanNotDeleteCarOperationThatDoesNotBelongs(): void
    {
        $car = Car::factory()->create();

        $user = User::factory()->create([
            'organization_id' => $car->organization_id,
        ]);

        $operation = CarOperation::factory()->create();

        $this->actingAs($user)
            ->deleteJson(route('cars.operations.destroy', [
                'car' => $car,
                'operation' => $operation
            ]))
            ->assertForbidden();
    }
}
