<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\Organization;
use App\Models\OrganizationInvitation;
use App\Models\User;
use App\Notifications\InvitedToOrganization;
use Filament\Actions\DeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

/**
 * @see \App\Filament\Resources\UserResource
 */
class UserResourceTest extends FilamentTestCase
{
    use RefreshDatabase;

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
                'record' => User::factory()->create([
                    'organization_id' => null,
                ]),
            ]))
            ->assertNotFound();
    }

    public function testListsCorrectUsers()
    {
        $users = User::factory()->count(3)->create([
            'organization_id' => $this->user->organization->id,
        ]);

        $organization = Organization::factory()->create();

        $hidden = User::factory()->count(3)->create([
            'organization_id' => $organization->id,
        ]);

        Livewire::test(ListUsers::class)
            ->assertCanSeeTableRecords($users)
            ->assertCanNotSeeTableRecords($hidden);
    }

    public function testCreatesUser()
    {
        $data = User::factory()->make()->toArray();

        $data['password'] = 'password';

        Livewire::test(CreateUser::class)
            ->fillForm($data)
            ->call('create')
            ->assertHasNoFormErrors();

        $user = User::firstWhere('email', $data['email']);

        $this->assertNotNull($user);

        $this->assertEquals($data['firstname'], $user->firstname);
        $this->assertEquals($data['lastname'], $user->lastname);
        $this->assertEquals($data['email'], $user->email);
        $this->assertEquals($data['car_id'], $user->car_id);
        $this->assertEquals($this->user->organization->id, $user->organization->id);
    }

    public function testUpdatesUser()
    {
        $user = User::factory()->create([
            'organization_id' => $this->user->organization->id,
        ]);

        $data = User::factory()
            ->make()
            ->toArray();

        Livewire::test(EditUser::class, [
            'record' => $user->id,
        ])->fillForm($data)
            ->call('save')
            ->assertHasNoFormErrors();

        $user = $user->fresh();

        $this->assertEquals($data['firstname'], $user->firstname);
        $this->assertEquals($data['lastname'], $user->lastname);
        $this->assertEquals($data['email'], $user->email);
        $this->assertEquals($data['car_id'], $user->car_id);
        $this->assertEquals($this->user->organization->id, $user->organization->id);
    }

    public function testDeletesUser()
    {
        $user = User::factory()->create([
            'organization_id' => $this->user->organization->id,
        ]);

        Livewire::test(EditUser::class, [
            'record' => $user->id,
        ])->callAction(DeleteAction::class);

        $this->assertModelMissing($user);
    }

    public function testInvitesUser()
    {
        Notification::fake();

        Livewire::test(ListUsers::class)
            ->callAction('invite', [
                'email' => $email = 'test@example.com'
            ]);

        Notification::assertSentOnDemand(InvitedToOrganization::class, function ($notification, $channels, $notifable) use ($email) {
            return $notification->invitation->email === $email && $notifable->routes['mail'] === $email;
        });
    }

    public function testDoesNotInvitesUserIfInvitationAlreadyExists()
    {
        Notification::fake();

        OrganizationInvitation::factory()
            ->recycle($this->user->organization)
            ->create([
                'email' => $email = 'test@example.com'
            ]);

        Livewire::test(ListUsers::class)
            ->callAction('invite', [
                'email' => $email,
            ])->assertNotified('User already exists');

        Notification::assertNothingSent();
    }
}
