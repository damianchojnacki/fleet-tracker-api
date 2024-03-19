<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Car;
use App\Models\Trip;
use App\Models\TripPoint;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UserTripController
 */
class UserTripControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanListTrips(): void
    {
        Trip::factory()
            ->count(3)
            ->create();

        $car = Car::factory()->create();

        $user = User::factory()->create([
            'organization_id' => $car->organization_id,
        ]);

        Trip::factory()
            ->count(3)
            ->recycle($car)
            ->recycle($user)
            ->create();

        $response = $this->actingAs($user)
            ->getJson(route('user.trips.index'))
            ->assertSuccessful();

        $this->assertNotNull($response->json());
        $this->assertCount(3, $response->json());
    }

    public function testUserCanShowTrip(): void
    {
        $car = Car::factory()->create();

        $user = User::factory()->create([
            'organization_id' => $car->organization_id,
        ]);

        $trip = Trip::factory()
            ->recycle($car)
            ->recycle($user)
            ->create();

        TripPoint::factory()
            ->count(3)
            ->recycle($trip)
            ->create();

        $response = $this->actingAs($user)
            ->getJson(route('user.trips.show', $trip))
            ->assertSuccessful();

        $this->assertNotNull($response->json());
        $this->assertEquals($trip->id, $response->json('id'));
        $this->assertCount(3, $response->json('points'));
    }

    public function testUserCanNotShowTripThatDoesNotOwn(): void
    {
        $trip = Trip::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user)
            ->getJson(route('user.trips.show', $trip))
            ->assertForbidden();
    }

    public function testUserCanCreateTrip(): void
    {
        $car = Car::factory()->create();

        $user = User::factory()->create([
            'organization_id' => $car->organization_id,
        ]);

        $body = Trip::factory()->make([
            'car_id' => $car->id,
        ]);

        $response = $this->actingAs($user)
            ->postJson(route('user.trips.store'), $body->toArray())
            ->assertSuccessful();

        $this->assertNotNull($response->json());

        $trip = Trip::find($response->json('id'));

        $this->assertNotNull($trip);
        $this->assertEquals($car->id, $trip->car->id);
        $this->assertEquals($user->id, $trip->user->id);
        $this->assertEquals($body->note, $trip->note);
        $this->assertEquals($body->from, $trip->from);
        $this->assertEquals($body->to, $trip->to);
        $this->assertEquals($body->distance, $trip->distance);
        $this->assertEquals($body->starts_at->toDateTimeString(), $trip->starts_at->toDateTimeString());
    }

    public function testUserCanNotCreateTripToCarThatDoesNotBelongs(): void
    {
        $car = Car::factory()->create();

        $user = User::factory()->create([
            'car_id' => null,
        ]);

        $this->actingAs($user)
            ->postJson(route('user.trips.store'), [
                'car_id' => $car->id,
            ])
            ->assertForbidden();
    }

    public function testUserCanUpdateTrip(): void
    {
        $car = Car::factory()->create();

        $user = User::factory()->create([
            'organization_id' => $car->organization_id,
        ]);

        $trip = Trip::factory()
            ->recycle($car)
            ->recycle($user)
            ->create();

        $body = Trip::factory()->make();

        $this->actingAs($user)
            ->putJson(route('user.trips.update', $trip), $body->toArray())
            ->assertSuccessful();

        $trip = $trip->fresh();

        $this->assertEquals($user->id, $trip->user->id);
        $this->assertEquals($body->car_id, $trip->car->id);
        $this->assertEquals($body->note, $trip->note);
        $this->assertEquals($body->from, $trip->from);
        $this->assertEquals($body->to, $trip->to);
        $this->assertEquals($body->distance, $trip->distance);
        $this->assertEquals($body->starts_at->toDateTimeString(), $trip->starts_at->toDateTimeString());
    }

    public function testUserCanNotUpdateTripThatDoesNotBelongs(): void
    {
        $trip = Trip::factory()->create();

        $user = User::factory()->create();

        $data = Trip::factory()->make();

        $this->actingAs($user)
            ->putJson(route('user.trips.update', $trip), $data->toArray())
            ->assertForbidden();
    }

    public function testUserCanDeleteTrip(): void
    {
        $car = Car::factory()->create();

        $user = User::factory()->create([
            'organization_id' => $car->organization_id,
        ]);

        $trip = Trip::factory()
            ->recycle($car)
            ->recycle($user)
            ->create();

        $this->actingAs($user)
            ->deleteJson(route('user.trips.destroy', $trip))
            ->assertSuccessful();

        // Ensure the trip is deleted from the database
        $this->assertModelMissing($trip);
    }

    public function testUserCanNotDeleteTripThatDoesNotBelongs(): void
    {
        $trip = Trip::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user)
            ->deleteJson(route('user.trips.destroy', $trip))
            ->assertForbidden();
    }
}
