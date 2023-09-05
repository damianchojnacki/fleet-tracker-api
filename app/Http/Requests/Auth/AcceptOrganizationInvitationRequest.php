<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class AcceptOrganizationInvitationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('accept', $this->invitation);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<string>>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'exists:users,email'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($this->organization->hasUserWithEmail($this->email)) {
                    $validator->errors()->add(
                        'email',
                        __('This user already belongs to the team.')
                    );
                }
            }
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'email' => $this->invitation->email,
        ]);
    }
}
