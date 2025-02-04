<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
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
        $userType = $this->input('type');

        $commonRules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'standard_id' => 'required',
            'mobile' => 'required',
            'school' => 'required',
            'img' => 'file|mimes:jpeg,png,jpg',
            'type' => 'required',
            'books' => 'required',
        ];

        if ($userType === 'teacher') {
            return $commonRules;
        }

        return array_merge($commonRules, [
            'dob' => 'required',
        ]);
    }
}
