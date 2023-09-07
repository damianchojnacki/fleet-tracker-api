<?php

namespace Database\Seeders;

use App\Models\Trip;
use App\Models\TripPoint;
use Illuminate\Database\Seeder;

class TripPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Trip::all()->each(function (Trip $trip) {
            $point = [
                52.2453 + rand(-9999, 9999) / 10000,
                20.9808 + +rand(-9999, 9999) / 10000,
            ];

            $points = [];

            foreach (range(0, rand(10, 300)) as $i) {
                $points[] = [
                    'trip_id' => $trip->id,
                    'lat' => $point[0] += rand(-999, 999) / 100000,
                    'lng' => $point[1] += rand(-999, 999) / 100000,
                    'created_at' => now()->addMinutes(rand($i, $i + 10)),
                ];
            }

            TripPoint::insert($points);

            $trip->update([
                'distance' => $trip->calculateDistance(),
            ]);
        });
    }
}
