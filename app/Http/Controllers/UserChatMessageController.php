<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserChatMessageRequest;
use App\Http\Resources\ChatMessageResource;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;

class UserChatMessageController extends Controller
{
    /**
     * List user chat messages.
     */
    public function index(Request $request): AnonymousResourceCollection|Collection
    {
        $trips = $request->user()
            ->chatMessages()
            ->with('author')
            ->get();

        return ChatMessageResource::collection($trips);
    }

    /**
     * Create user chat message.
     */
    public function store(CreateUserChatMessageRequest $request): ChatMessage
    {
        $message = new ChatMessage($request->validated());
        $message->author()->associate($request->user());
        $message->save();

        return $message;
    }
}
