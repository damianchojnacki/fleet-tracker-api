<?php

namespace App\Http\Resources;

use App\Models\Car;
use App\Models\CarOperation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin CarOperation */
class CarOperationResource extends JsonResource
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
            'type' => $this->type,
            'cost' => $this->cost,
            'note' => $this->note,
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
