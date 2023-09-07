<?php

namespace App\Http\Controllers;

use App\Http\Resources\CarBrandResource;
use App\Models\CarBrand;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CarBrandController extends Controller
{
    /**
     * List all car brands.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $brands = CarBrand::all();

        return CarBrandResource::collection($brands);
    }

    /**
     * Show a specific car brand.
     */
    public function show(Request $request, CarBrand $brand): CarBrandResource
    {
        return new CarBrandResource($brand);
    }
}
