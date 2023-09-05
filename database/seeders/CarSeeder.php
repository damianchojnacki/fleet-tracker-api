<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarBrand;
use App\Models\CarModel;
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
        $brands = CarBrand::all();
        $models = CarModel::all();

        Car::factory()
            ->recycle($organizations)
            ->recycle($brands)
            ->recycle($models)
            ->count(30)
            ->create();
    }
}
