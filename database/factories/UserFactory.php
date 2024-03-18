<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'car_id' => function (array $attributes) {
                return Car::whereRelation('organization', 'id', $attributes['organization_id'])
                    ->inRandomOrder()
                    ->first()
                    ?->id;
            },
            'organization_id' => Organization::inRandomOrder()->first()?->id,
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_admin' => false,
        ];
    }
}
