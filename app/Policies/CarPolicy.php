<?php

namespace App\Policies;

use App\Models\Car;
use App\Models\User;

class CarPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Car $car): bool
    {
        return $user->organization?->id == $car->organization->id;
    }

    /**
     * Determine whether the user can associate the car.
     */
    public function associate(User $user, Car $car): bool
    {
        return $user->organization?->id == $car->organization->id;
    }
}
