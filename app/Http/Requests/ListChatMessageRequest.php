<?php

namespace App\Http\Requests;

use App\Models\ChatMessage;
use Illuminate\Foundation\Http\FormRequest;

class ListChatMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', ChatMessage::class) ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<string>>
     */
    public function rules(): array
    {
        return [];
    }
}
