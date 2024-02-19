<?php

namespace App\Policies;

use App\Models\User;

class ChatMessagePolicy
{
    /**
     * Determine whether the user can create the model.
     */
    public function viewAny(User $user): bool
    {
        return $user->ownsOrganization($user->organization);
    }

    /**
     * Determine whether the user can create the model.
     */
    public function create(User $user): bool
    {
        return $user->ownsOrganization($user->organization);
    }
}
