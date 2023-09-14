<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarOperation;
use Illuminate\Database\Seeder;

class CarOperationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Car::with('users')->get()->each(function (Car $car) {
            CarOperation::factory()
                ->count(rand(0, 10))
                ->recycle($car)
                ->recycle($car->users->first())
                ->create();
        });
    }
}
