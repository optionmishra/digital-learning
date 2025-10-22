<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssessmentRequest extends FormRequest
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
            'name' => 'required',
            'standard_id' => 'required',
            'subject_id' => 'required',
            'series_id' => 'required|exists:series,id',
            'book_id' => 'required',
            'type' => 'required|in:mcq,olympiad',
            'duration' => 'required',
        ];
    }
}
