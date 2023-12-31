<?php

namespace App\Services;

use App\Models\OrganizationInvitation;
use App\Models\User;
use Illuminate\Support\Facades\URL;

class FrontendUrlGenerator
{
    public function __construct(protected string $url)
    {
    }

    public function path(string $path): string
    {
        return "{$this->url}/{$path}";
    }

    public function acceptOrganizationInvitation(OrganizationInvitation $invitation): string
    {
        $signature = URL::signature('organization-invitations.accept', [
            'invitation' => $invitation->id,
        ]);

        return $this->path("associate-organization?id={$invitation->id}&signature={$signature}");
    }

    public function verifyEmail(User $user): string
    {
        $id = $user->getKey();
        $hash = sha1($user->getEmailForVerification());

        $signature = URL::signature('verification.verify', [
            'id' => $id,
            'hash' => $hash,
        ]);

        return $this->path("verify-email?id={$id}&hash={$hash}&signature={$signature}");
    }

    public function resetPassword(User $user, string $token): string
    {
        return $this->path("password-reset/{$token}?email={$user->getEmailForPasswordReset()}");
    }

    public function register(): string
    {
        return $this->path('register');
    }
}
