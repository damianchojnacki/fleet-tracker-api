<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserTripPointRequest;
use App\Models\Trip;
use App\Models\TripPoint;
use Illuminate\Http\Request;

class UserTripPointController extends Controller
{
    /**
     * Create user trip point.
     */
    public function store(CreateUserTripPointRequest $request, Trip $trip): TripPoint
    {
        /** @var TripPoint $point */
        $point = $trip->points()->create($request->validated());

        return $point;
    }
}
