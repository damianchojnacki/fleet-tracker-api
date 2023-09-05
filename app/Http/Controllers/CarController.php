<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowCarRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $cars = Car::whereHas('organization', fn(Builder $q) =>
            $q->where('id', $request->user()?->organization?->id)
        )->get();

        return $this->ok(
            CarResource::collection($cars)
        );
    }

    public function show(ShowCarRequest $request, Car $car): JsonResponse
    {
        $car->load(['brand']);

        return $this->ok(
            new CarResource($car)
        );
    }
}
