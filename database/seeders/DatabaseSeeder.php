<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            OrganizationSeeder::class,
            CarSeeder::class,
            UserSeeder::class,
            OrganizationInvitationSeeder::class,
            TripSeeder::class,
            TripPointSeeder::class,
            CarOperationSeeder::class,
            ChatMessageSeeder::class,
        ]);
    }
}
