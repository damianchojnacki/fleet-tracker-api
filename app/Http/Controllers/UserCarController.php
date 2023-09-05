<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AssociateCarToUserRequest;
use App\Http\Resources\CarCollection;
use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
