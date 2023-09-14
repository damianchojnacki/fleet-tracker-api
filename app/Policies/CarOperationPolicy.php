<?php

namespace App\Policies;

use App\Models\Car;
use App\Models\CarOperation;
use App\Models\User;

class CarOperationPolicy
{
    /**
     * Determine whether the user can create the model.
     */
    public function viewAny(User $user, Car $car): bool
    {
        return $user->car?->id == $car->id;
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
    public function update(User $user, CarOperation $operation): bool
    {
        return $operation->user?->id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CarOperation $operation): bool
    {
        return $operation->user?->id == $user->id;
    }
}
