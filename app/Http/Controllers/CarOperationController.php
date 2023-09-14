<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCarOperationRequest;
use App\Http\Requests\DeleteCarOperationRequest;
use App\Http\Requests\ListCarOperationRequest;
use App\Http\Requests\UpdateCarOperationRequest;
use App\Http\Resources\CarOperationResource;
use App\Models\Car;
use App\Models\CarOperation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

class CarOperationController extends Controller
{
    /**
     * List car operations.
     */
    public function index(ListCarOperationRequest $request, Car $car): AnonymousResourceCollection
    {
        $operations = $car->operations()->with('user')->paginate();

        return CarOperationResource::collection($operations);
    }

    /**
     * Create car operation.
     */
    public function store(CreateCarOperationRequest $request, Car $car): CarOperationResource
    {
        $operation = new CarOperation($request->validated());
        $operation->car()->associate($car);
        $operation->user()->associate($request->user());
        $operation->save();

        return new CarOperationResource($operation);
    }

    /**
     * Update car operation.
     */
    public function update(UpdateCarOperationRequest $request, Car $car, CarOperation $operation): CarOperationResource
    {
        $operation->update($request->validated());

        return new CarOperationResource($operation);
    }

    /**
     * Delete car operation.
     *
     * @throws Throwable
     */
    public function destroy(DeleteCarOperationRequest $request, Car $car, CarOperation $operation): JsonResponse
    {
        $operation->deleteOrFail();

        return $this->noContent();
    }
}
