<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(3)->create([
            'car_id' => null,
            'organization_id' => null,
        ])->each(function (User $user) {
            $organization = Organization::factory()->create([
                'owner_id' => $user->id,
            ]);

            $user->update([
                'organization_id' => $organization->id,
            ]);
        });
    }
}
