<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserTripRequest;
use App\Http\Requests\DeleteUserTripRequest;
use App\Http\Requests\ShowUserTripRequest;
use App\Http\Requests\UpdateUserTripRequest;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

class UserTripController extends Controller
{
    /**
     * List user trips.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $trips = $request->user()->trips()->with('car.brand')->get();

        return TripResource::collection($trips);
    }

    /**
     * Show user trip.
     */
    public function show(ShowUserTripRequest $request, Trip $trip): TripResource
    {
        $trip->load(['car', 'points']);

        return new TripResource($trip);
    }

    /**
     * Create user trip.
     */
    public function store(CreateUserTripRequest $request): Trip
    {
        $trip = new Trip($request->validated());
        $trip->user()->associate($request->user());
        $trip->save();

        return $trip;
    }

    /**
     * Update user trip.
     */
    public function update(UpdateUserTripRequest $request, Trip $trip): Trip
    {
        $trip->update($request->validated());

        return $trip;
    }

    /**
     * Delete user trip.
     *
     * @throws Throwable
     */
    public function destroy(DeleteUserTripRequest $request, Trip $trip): JsonResponse
    {
        $trip->deleteOrFail();

        return $this->noContent();
    }
}
