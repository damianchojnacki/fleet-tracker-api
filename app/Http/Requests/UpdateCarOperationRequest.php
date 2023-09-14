<?php

namespace App\Http\Requests;

use App\Enums\CarOperationType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCarOperationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->operation) ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<string>>
     */
    public function rules(): array
    {
        return [
            'type' => [Rule::in(CarOperationType::values())],
            'cost' => ['numeric', 'min:0'],
            'note' => ['nullable', 'string', 'max:1024'],
        ];
    }
}
