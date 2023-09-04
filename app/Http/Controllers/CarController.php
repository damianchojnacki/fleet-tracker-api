<?php

namespace App\Http\Controllers;

use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $cars = Car::all();

        return $this->ok(
            CarResource::collection($cars)
        );
    }

    public function show(Request $request, Car $car): JsonResponse
    {
        $car->load(['brand', 'model']);

        return $this->ok(
            new CarResource($car)
        );
    }
}
