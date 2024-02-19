<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UserChatMessageController
 */
class UserChatMessageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanListChatMessages(): void
    {
        ChatMessage::factory()
            ->count(3)
            ->create();

        $user = User::factory()->create();

        ChatMessage::factory()
            ->count(3)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->actingAs($user)
            ->getJson(route('user.chat-messages.index'))
            ->assertSuccessful();

        $this->assertNotNull($response->json());
        $this->assertCount(3, $response->json());
    }

    public function testUserCanCreateChatMessage(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(route('user.chat-messages.store'), [
                'user_id' => $user->id,
                'content' => $content = Str::random(),
            ])
            ->assertSuccessful();

        $this->assertNotNull($response->json());

        $message = ChatMessage::find($response->json('id'));

        $this->assertNotNull($message);
        $this->assertEquals($user->id, $message->author->id);
        $this->assertEquals($user->id, $message->user->id);
        $this->assertEquals($content, $message->content);
    }

    public function testUserCanNotCreateChatMessageWithDifferentUserId(): void
    {
        $anotherUser = User::factory()->create();

        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('user.chat-messages.store'), [
                'user_id' => $anotherUser->id,
                'content' => Str::random(),
            ])
            ->assertForbidden();
    }

    public function testOrganizationOwnerCanCreateChatMessageWithDifferentUserId(): void
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

        $response = $this->actingAs($owner)
            ->postJson(route('user.chat-messages.store'), [
                'user_id' => $user->id,
                'content' => Str::random(),
            ])
            ->assertSuccessful();

        $message = ChatMessage::find($response->json('id'));

        $this->assertNotNull($message);
        $this->assertEquals($owner->id, $message->author->id);
        $this->assertEquals($user->id, $message->user->id);
    }
}
