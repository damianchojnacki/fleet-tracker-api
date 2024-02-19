<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OrganizationChatMessageController
 */
class OrganizationChatMessageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testOrganizationOwnerCanListGroupedChatMessagesByUser(): void
    {
        $owner = User::factory()->create();

        $organization = Organization::factory()->create([
            'owner_id' => $owner->id,
        ]);

        $owner->update([
            'organization_id' => $organization->id,
        ]);

        $user = User::factory()
            ->recycle($organization)
            ->create();

        ChatMessage::factory()
            ->count(3)
            ->create([
                'user_id' => $user->id,
            ]);

        $user2 = User::factory()
            ->recycle($organization)
            ->create();

        ChatMessage::factory()
            ->count(3)
            ->create([
                'user_id' => $user2->id,
            ]);

        $response = $this->actingAs($owner)
            ->getJson(route('chat-messages.index'))
            ->assertSuccessful();

        $this->assertNotNull($response->json());
        $this->assertCount(2, $response->json());
        $this->assertCount(3, $response->json($user->id));
        $this->assertCount(3, $response->json($user2->id));
    }
}
