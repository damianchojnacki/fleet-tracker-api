<?php

namespace Tests\Unit;

use App\Models\OrganizationInvitation;
use App\Models\User;
use App\Services\Frontend;
use Tests\TestCase;

class FrontendUrlGeneratorTest extends TestCase
{
    public function testPathHasCorrectUrl(): void
    {
        $base = 'https://example.com';

        config()->set('app.frontend_url', $base);

        $path = 'test';

        $url = Frontend::url()->path($path);

        $this->assertStringStartsWith($base, $url);
        $this->assertStringEndsWith($path, $url);
    }

    public function testAcceptInvitationGetsCorrectUrl(): void
    {
        $invitation = new OrganizationInvitation([
            'id' => 9876,
        ]);

        $url = Frontend::url()->acceptOrganizationInvitation($invitation);

        $this->assertStringContainsString('?id=9876', $url);
        $this->assertStringContainsString('&signature=', $url);
    }

    public function testVerifyEmailGetsCorrectUrl(): void
    {
        $user = new User([
            'id' => 9876,
            'email' => 'test@example.com',
        ]);

        $url = Frontend::url()->verifyEmail($user);

        $this->assertStringContainsString(9876, $url);
        $this->assertStringContainsString('id='.$user->id, $url);
        $this->assertStringContainsString('hash='.sha1($user->email), $url);
        $this->assertStringContainsString('signature=', $url);
    }
}
