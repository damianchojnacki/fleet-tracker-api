<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\Organization;
use App\Models\User;
use Livewire\Livewire;

/**
 * @see \App\Filament\Resources\UserResource
 */
class UserResourceTest extends FilamentTestCase
{
    public function testRendersListPage()
    {
        $this->actingAs($this->user)
            ->get(UserResource::getUrl('index'))
            ->assertSuccessful();
    }

    public function testRendersCreatePage()
    {
        $this->actingAs($this->user)
            ->get(UserResource::getUrl('create'))
            ->assertSuccessful();
    }

    public function testRendersUpdatePage()
    {
        $this->actingAs($this->user)
            ->get(UserResource::getUrl('edit', [
                'record' => User::factory()->create([
                    'organization_id' => $this->user->organization->id,
                ]),
            ]))
            ->assertSuccessful();
    }

    public function testDoesRenderUpdatePageForModelOutsideTenacy()
    {
        $this->actingAs($this->user)
            ->get(UserResource::getUrl('edit', [
                'record' => User::factory()->create(),
            ]))
            ->assertNotFound();
    }

    public function testListsCorrectUsers()
    {
        $organization = Organization::factory()->create();

        User::factory()->create([
            'organization_id' => $organization->id,
        ]);

        $users = User::factory()->count(3)->create([
            'organization_id' => $this->user->organization->id,
        ]);

        Livewire::test(ListUsers::class)
            ->assertCanSeeTableRecords($users);
    }
}
