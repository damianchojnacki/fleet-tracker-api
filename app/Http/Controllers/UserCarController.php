<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssociateCarToUserRequest;
use App\Models\Car;
use Illuminate\Http\JsonResponse;

class UserCarController extends Controller
{
    /**
     * Associate car to user.
     */
    public function update(AssociateCarToUserRequest $request, Car $car): JsonResponse
    {
        $user = $request->user();

        $user->car()->associate($car);
        $user->save();

        return $this->noContent();
    }
}
