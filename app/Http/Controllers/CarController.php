<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowCarRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CarController extends Controller
{
    /**
     * List available cars.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $cars = Car::query()
            ->whereHas('organization',
                fn (Builder $q) => $q->where('id', $request->user()?->organization?->id)
            )
            ->with('brand')
            ->where('id', '!=', $request->user()?->car_id)
            ->where('is_active', true)
            ->get();

        return CarResource::collection($cars);
    }

    /**
     * Show a specific car.
     */
    public function show(ShowCarRequest $request, Car $car): CarResource
    {
        $car->load(['brand']);

        return new CarResource($car);
    }
}
