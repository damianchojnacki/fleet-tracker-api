<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\CarBrand;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'organization_id' => Organization::factory(),
            'brand_id' => CarBrand::inRandomOrder()->first()?->id,
            'plate_number' => Str::upper(dechex(rand(11, 15)).dechex(rand(11, 15)).bin2hex(random_bytes(3))),
            'vin' => rand(10000000000000000, 99999999999999999),
            'mileage' => rand(10000, 500000),
            'is_active' => $this->faker->boolean,
            'specs' => [
                'year' => rand(2000, 2023),
                'model' => $this->faker->word,
                'color' => $this->faker->colorName,
                'fuel_type' => $this->faker->randomElement(['gas', 'diesel', 'electricity', 'hybrid']),
                'drive' => $this->faker->randomElement(['rwd', 'fwd', 'awd']),
                'transmission' => $this->faker->randomElement(['a', 'm']),
                'fuel_consumption' => rand(6, 20),
            ],
        ];
    }
}
