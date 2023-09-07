<?php

namespace App\Policies;

use App\Models\OrganizationInvitation;
use App\Models\User;

class OrganizationInvitationPolicy
{
    /**
     * Determine whether the user can accept invitation.
     */
    public function accept(User $user, OrganizationInvitation $invitation): bool
    {
        return $user->email === $invitation->email;
    }

    /**
     * Determine whether the user can cancel invitation.
     */
    public function cancel(User $user, OrganizationInvitation $invitation): bool
    {
        return $user->id === $invitation->organization->owner->id;
    }
}
