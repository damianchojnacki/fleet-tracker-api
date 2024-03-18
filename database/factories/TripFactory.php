<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'car_id' => Car::factory(),
            'user_id' => User::factory(),
            'distance' => $this->faker->randomFloat(2, 0, 9999.99),
            'is_finished' => $this->faker->boolean,
            'note' => $this->faker->paragraph(rand(0, 2)),
            'from' => $this->faker->sentence(),
            'to' => $this->faker->sentence(),
        ];
    }
}
