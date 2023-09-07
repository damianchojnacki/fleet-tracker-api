<?php

namespace App\Http\Requests;

use App\Models\Car;
use App\Models\Trip;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserTripRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->car_id && ($this->user()?->can('create', [Trip::class, Car::find($this->car_id)]) ?? false);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<string>>
     */
    public function rules(): array
    {
        return [
            'car_id' => ['required', 'exists:cars,id'],
        ];
    }
}
