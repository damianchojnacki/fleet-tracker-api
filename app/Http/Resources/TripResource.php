<?php

namespace App\Http\Resources;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Trip */
class TripResource extends JsonResource
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
            'car_id' => $this->car_id,
            'user_id' => $this->user_id,
            'note' => $this->note,
            'is_finished' => $this->is_finished,
            'points' => TripPointResource::collection($this->whenLoaded('points')),
            'car' => new CarResource($this->whenLoaded('car')),
        ];
    }
}
