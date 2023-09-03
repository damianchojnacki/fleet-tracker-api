<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Trip;

class TripFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Trip::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'distance' => $this->faker->randomFloat(2, 0, 9999.99),
            'is_finished' => $this->faker->boolean,
            'note' => $this->faker->paragraph(rand(0, 3)),
        ];
    }
}
