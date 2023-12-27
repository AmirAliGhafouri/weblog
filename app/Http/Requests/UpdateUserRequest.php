<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'sometimes|Nullable|string|max:255',
            'last_name' => 'sometimes|Nullable|string|max:255',
            'username' => 'sometimes|Nullable|string|unique:users|max:255',
            'phone_number' => 'sometimes|Nullable',
            'email' => 'sometimes|Nullable|string|email|max:255|unique:users',
        ];
    }
}
