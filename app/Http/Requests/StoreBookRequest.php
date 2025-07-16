<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'media_file' => 'file|mimes:jpeg,png,jpg', // ,gif,mp4,mov,ogg',
            'about' => 'required',
            'board_id' => 'required',
            'standard_id' => 'required',
            'subject_id' => 'required',
            'author_id' => 'required',
        ];
    }
}
