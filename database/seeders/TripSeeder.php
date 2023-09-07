<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Organization;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cars = Car::all();
        $users = User::all();

        Trip::factory()
            ->recycle($cars)
            ->recycle($users)
            ->count(300)
            ->create();
    }
}
