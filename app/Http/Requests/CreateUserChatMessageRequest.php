<?php

namespace App\Http\Requests;

use App\Models\ChatMessage;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserChatMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user_id === $this->user()?->id || $this->user()?->can('create', ChatMessage::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<string>>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'content' => ['required', 'string', 'max:1024'],
        ];
    }
}
