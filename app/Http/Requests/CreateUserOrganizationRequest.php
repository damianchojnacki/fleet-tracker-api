<?php

namespace App\Http\Requests;

use App\Models\Car;
use App\Models\Trip;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserOrganizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // TODO allow creating organization only if user has subscription
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
