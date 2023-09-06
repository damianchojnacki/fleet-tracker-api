<?php

namespace Tests\Unit;

use App\Models\OrganizationInvitation;
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

    public function testAcceptInvitationHasCorrectUrl(): void
    {
        $invitation = new OrganizationInvitation([
            'id' => 9876,
        ]);

        $url = Frontend::url()->acceptOrganizationInvitation($invitation);

        $this->assertStringContainsString(9876, $url);
        $this->assertStringContainsString('?signature=', $url);
    }
}
