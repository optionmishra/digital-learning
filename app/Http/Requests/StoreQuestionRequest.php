<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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
            'question_text' => 'string',
            'question_img' => 'file',
            'option_1' => 'string',
            'option_1_img' => 'file',
            'option_2' => 'string',
            'option_2_img' => 'file',
            'option_3' => 'string',
            'option_3_img' => 'file',
            'option_4' => 'string',
            'option_4_img' => 'file',
            'correct_option' => 'required|numeric|between:1,4',
        ];
    }
}
