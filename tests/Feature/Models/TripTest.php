<?php

namespace Tests\Feature\Models;

use App\Models\Trip;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Models\Trip
 */
class TripTest extends TestCase
{
    use RefreshDatabase;

    public function testCalculatesDistanceBetweenManyPoints(): void
    {
        $trip = Trip::factory()->create();

        $trip->points()->createMany([
            [
                'lat' => 53.1222,
                'lng' => 17.9945,
            ],
            [
                'lat' => 52.2327,
                'lng' => 21.0141,
            ],
        ]);

        $this->assertEquals(226.3, round($trip->calculateDistance(), 1));

        $trip->points()->create([
            'lat' => 53.1322,
            'lng' => 23.1687,
        ]);

        $trip->load('points');

        $this->assertEquals(226.3 + 176.3, round($trip->calculateDistance(), 1));
    }
}
