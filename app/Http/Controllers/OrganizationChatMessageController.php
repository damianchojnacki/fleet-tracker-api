<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListChatMessageRequest;
use App\Http\Resources\ChatMessageResource;
use App\Models\ChatMessage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;

class OrganizationChatMessageController extends Controller
{
    /**
     * List organization chat messages grouped by user.
     *
     * @return Collection<int, AnonymousResourceCollection>
     */
    public function index(ListChatMessageRequest $request): Collection
    {
        return ChatMessage::with(['author', 'user'])
            ->whereHas('user', fn (Builder $q) => $q->whereRelation('organization', 'id', $request->user()->organization->id)
            )
            ->latest()
            ->get()
            ->groupBy('user_id')
            ->map(fn ($messages) => ChatMessageResource::collection($messages));
    }
}
