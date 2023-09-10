<?php

namespace Tests\Feature\Notifications;

use App\Models\User;
use App\Services\Frontend;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CarController
 */
class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testRendersNotificationCorrectly(): void
    {
        $notification = new ResetPassword(
            $token = Str::random(),
        );

        $user = User::factory()->create();

        $content = $notification->toMail($user)->render();

        $this->assertStringContainsString(Frontend::url()->resetPassword($user, $token), html_entity_decode($content));
    }
}
