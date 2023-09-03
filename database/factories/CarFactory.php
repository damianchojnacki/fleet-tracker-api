<?php

namespace Database\Factories;

use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Car;

class CarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Car::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'model_id' => CarModel::factory(),
            'brand_id' => CarBrand::factory(),
            'plate_number' => Str::upper(dechex(rand(11, 15)) . dechex(rand(11, 15)) . bin2hex(random_bytes(3))),
            'vin' => rand(10000000000000000, 99999999999999999),
            'is_active' => $this->faker->boolean,
        ];
    }
}
