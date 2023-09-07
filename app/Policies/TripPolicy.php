<?php

namespace App\Policies;

use App\Models\Car;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TripPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Trip $trip): bool
    {
        return $trip->user->id == $user->id;
    }

    /**
     * Determine whether the user can create the model.
     */
    public function create(User $user, Car $car): bool
    {
        return $user->car?->id == $car->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Trip $trip): bool
    {
        return $trip->user->id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Trip $trip): bool
    {
        return $trip->user->id == $user->id;
    }
}
