<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\CarResource;
use App\Filament\Resources\CarResource\Pages\CreateCar;
use App\Filament\Resources\CarResource\Pages\EditCar;
use App\Filament\Resources\CarResource\Pages\ListCars;
use App\Filament\Resources\OrganizationInvitationResource;
use App\Filament\Resources\OrganizationInvitationResource\Pages\ListOrganizationInvitations;
use App\Models\Car;
use App\Models\OrganizationInvitation;
use Filament\Actions\DeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

/**
 * @see \App\Filament\Resources\OrganizationInvitationResource
 */
class OrganizationInvitationResourceTest extends FilamentTestCase
{
    use RefreshDatabase;

    public function testRendersListPage()
    {
        $this->actingAs($this->user)
            ->get(OrganizationInvitationResource::getUrl('index'))
            ->assertSuccessful();
    }

    public function testListsCorrectInvitations()
    {
        $invitations = OrganizationInvitation::factory()
            ->recycle(
                $this->user->organization
            )
            ->count(3)
            ->create();

        $hidden = OrganizationInvitation::factory()
            ->count(3)
            ->create();

        Livewire::test(ListOrganizationInvitations::class)
            ->assertCanSeeTableRecords($invitations)
            ->assertCanNotSeeTableRecords($hidden);
    }
}
