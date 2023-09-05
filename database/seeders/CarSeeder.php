<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = Organization::all();

        Car::factory()
            ->recycle($organizations)
            ->count(30)
            ->create();
    }
}
