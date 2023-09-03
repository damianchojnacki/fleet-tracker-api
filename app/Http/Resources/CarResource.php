<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'plate_number' => $this->plate_number,
            'vin' => $this->vin,
            'is_active' => $this->is_active,
            'brand' => CarBrandResource::make($this->whenLoaded('brand')),
        ];
    }
}
