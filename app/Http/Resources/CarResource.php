<?php

namespace App\Http\Resources;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Car */
class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'brand_id' => $this->brand_id,
            'mileage' => $this->mileage,
            'is_active' => $this->is_active,
            'specs' => $this->specs,
            'brand' => new CarBrandResource($this->whenLoaded('brand')),
        ];
    }
}
