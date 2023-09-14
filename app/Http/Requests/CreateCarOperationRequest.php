<?php

namespace App\Http\Requests;

use App\Enums\CarOperationType;
use App\Models\CarOperation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCarOperationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('create', [CarOperation::class, $this->car]) ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<string>>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in(CarOperationType::values())],
            'cost' => ['required', 'numeric', 'min:0'],
            'note' => ['nullable', 'string', 'max:1024'],
        ];
    }
}
