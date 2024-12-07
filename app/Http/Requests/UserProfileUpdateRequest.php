<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserProfileUpdateRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $this->user()->id,
            'mobile' => 'sometimes|required|string|max:15',
            'school' => 'sometimes|required|string|max:255',
            'dob' => 'nullable|date',
            'standard_id' => 'sometimes|required|exists:standards,id',
            'img' => 'nullable|file|mimes:jpeg,png,jpg',
        ];
    }
}
