<?php

namespace App\Http\Controllers;

use App\Http\Resources\BrandCollection;
use App\Http\Resources\CarBrandResource;
use App\Models\CarBrand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CarBrandController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $brands = CarBrand::all();

        return $this->ok(
            CarBrandResource::collection($brands)
        );
    }

    public function show(Request $request, CarBrand $brand): JsonResponse
    {
        return $this->ok(
            new CarBrandResource($brand)
        );
    }
}
