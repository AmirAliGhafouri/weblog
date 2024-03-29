<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateNewsRequest extends FormRequest
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
            'title' => 'required|string|max:60',
            'short_text' => 'required|string|max:255',
            'long_text' => 'required|string',     
            'image' => 'required|image|dimensions:max_width=6000,max_height=6000|max:2048',
            'categories' => 'sometimes|Nullable',
        ];
    }
}
