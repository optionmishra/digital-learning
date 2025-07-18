<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBatchQuestionsRequest extends FormRequest
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
            'subject_id' => 'required|exists:subjects,id',
            'book_id' => 'required|exists:books,id',
            'topic_id' => 'required|exists:topics,id',
            'assessment_id' => 'required|exists:assessments,id',
            'questions_file' => 'required|file',
            'images_file' => 'file|mimes:zip',
        ];
    }
}
