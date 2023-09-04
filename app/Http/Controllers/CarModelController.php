<?php

namespace App\Http\Controllers;

use App\Http\Resources\ModelCollection;
use App\Http\Resources\CarModelResource;
use App\Models\CarModel;
use App\Models\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CarModelController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $models = CarModel::all();

        return $this->ok(
            CarModelResource::collection($models),
        );
    }

    public function show(Request $request, CarModel $model): JsonResponse
    {
        $model->load('brand');

        return $this->ok(
            new CarModelResource($model),
        );
    }
}
