<?php

namespace App\Policies;

use App\Models\Trip;
use App\Models\User;

class TripPointPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function create(User $user, Trip $trip): bool
    {
        return $trip->user->id == $user->id;
    }
}
