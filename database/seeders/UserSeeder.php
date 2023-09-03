<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $cars = Car::all();

         User::factory(10)->recycle($cars)->create();

         User::factory()->create([
             'car_id' => null,
             'firstname' => 'Test',
             'lastname' => 'User',
             'email' => 'user@example.com',
         ]);

        User::factory()->create([
            'car_id' => null,
            'firstname' => 'Test',
            'lastname' => 'Admin',
            'email' => 'admin@example.com',
            'is_admin' => true,
        ]);
    }
}
