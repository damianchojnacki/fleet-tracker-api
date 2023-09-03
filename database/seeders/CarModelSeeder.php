<?php

namespace Database\Seeders;

use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class CarModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = CarBrand::all();

        CarModel::factory()
            ->recycle($brands)
            ->count(16)
            ->create();
    }
}
