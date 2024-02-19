<?php

namespace App\Http\Resources;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ChatMessage */
class ChatMessageResource extends JsonResource
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
            'author_id' => $this->author_id,
            'user_id' => $this->user_id,
            'content' => $this->content,
            'created_at' => $this->created_at,
            'author' => $this->whenLoaded('author', fn () => [
                'id' => $this->author->id,
                'firstname' => $this->author->firstname,
                'lastname' => $this->author->lastname,
            ]),
            'user' => $this->whenLoaded('user', fn () => [
                'id' => $this->author->id,
                'firstname' => $this->author->firstname,
                'lastname' => $this->author->lastname,
            ]),
        ];
    }
}
