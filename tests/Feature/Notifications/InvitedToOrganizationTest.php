<?php

namespace Tests\Feature\Notifications;

use App\Models\OrganizationInvitation;
use App\Models\User;
use App\Notifications\InvitedToOrganization;
use App\Services\Frontend;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CarController
 */
class InvitedToOrganizationTest extends TestCase
{
    use RefreshDatabase;

    public function testRendersNotificationCorrectly(): void
    {
        $notification = new InvitedToOrganization(
            $invitation = OrganizationInvitation::factory()->create()
        );

        $user = User::factory()->create();

        $content = $notification->toMail($user)->render();

        $this->assertStringContainsString($invitation->organization->name, $content);
        $this->assertStringContainsString(Frontend::url()->acceptOrganizationInvitation($invitation), html_entity_decode($content));
    }
}
