<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = CarBrand::all();
        $models = CarModel::all();

        Car::factory()
            ->recycle($brands)
            ->recycle($models)
            ->count(30)
            ->create();
    }
}
