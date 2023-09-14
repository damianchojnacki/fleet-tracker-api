<?php

namespace Database\Factories;

use App\Enums\CarOperationType;
use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CarOperation>
 */
class CarOperationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'car_id' => Car::factory(),
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(CarOperationType::cases()),
            'cost' => $this->faker->randomFloat(2, 1, 10000),
            'note' => rand(0, 1) ? $this->faker->text(100) : null,
        ];
    }
}
