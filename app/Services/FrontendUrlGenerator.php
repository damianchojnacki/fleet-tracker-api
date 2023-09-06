<?php

namespace App\Services;

use App\Models\OrganizationInvitation;
use Illuminate\Support\Facades\URL;

class FrontendUrlGenerator
{
    public function __construct(protected string $url) {}

    public function path(string $path): string
    {
        return "{$this->url}/{$path}";
    }

    public function acceptOrganizationInvitation(OrganizationInvitation $invitation): string
    {
        $signature = URL::signature('organization-invitations.accept', [
            'invitation' => $invitation->id,
        ]);

        return $this->path("organization-invitations/{$invitation->id}?signature=$signature");
    }

    public function register(): string
    {
        return $this->path('register');
    }
}
