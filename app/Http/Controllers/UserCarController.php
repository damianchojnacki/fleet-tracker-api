<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssociateCarToUserRequest;
use App\Http\Resources\CarCollection;
use App\Models\Car;
use Illuminate\Http\JsonResponse;

class UserCarController extends Controller
{
    public function update(AssociateCarToUserRequest $request, Car $car): JsonResponse
    {
        $user = $request->user();

        $user->car()->associate($car);
        $user->save();

        return $this->noContent();
    }
}
