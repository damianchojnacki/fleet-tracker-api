<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Organization;
use App\Models\OrganizationInvitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UserOrganizationController
 */
class UserOrganizationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanCreateOrganization()
    {
        $user = User::factory()->create();

        $body = Organization::factory()->make();

        $response = $this->actingAs($user)
            ->postJson(route('user.organizations.store'), $body->toArray())
            ->assertSuccessful();

        $organization = Organization::find($response->json('id'));

        $this->assertNotNull($organization);
        $this->assertEquals($organization->id, $user->organization?->id);
        $this->assertEquals($organization->owner->id, $user->id);
    }
}
