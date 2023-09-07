<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Trip;
use App\Models\TripPoint;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UserTripPointController
 */
class UserTripPointControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanCreatePoint(): void
    {
        $user = User::factory()->create();

        $trip = Trip::factory()->recycle($user)->create();

        $response = $this->actingAs($user)
            ->postJson(route('user.trips.points.store', $trip), [
                'lat' => 1,
                'lng' => 1,
            ])
            ->assertSuccessful();

        $this->assertNotNull($response->json());

        $point = TripPoint::find($response->json('id'));

        $this->assertNotNull($point);
        $this->assertEquals(1, $point->lat);
        $this->assertEquals(1, $point->lng);
        $this->assertEquals($trip->id, $point->trip->id);
    }
}
