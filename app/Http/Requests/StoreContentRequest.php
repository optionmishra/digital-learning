<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContentRequest extends FormRequest
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
      'content_type_id' => 'required',
      'standard_id' => 'required',
      'subject_id' => 'required',
      'book_id' => 'required',
      'topic_id' => 'required',
      'title' => 'required',
      'tags' => 'required',
      'img' => 'file|mimes:jpeg,png,jpg',
      'about' => 'required',
      'src_type' => 'required',
      'file' => 'file',
      'url' => 'url|nullable',
      'creator' => '',
      'price' => '',
    ];
    // $type = request()->get('type');
    // return match ($type) {
    //   'Video' => [
    //     'content_type_id' => 'required',
    //     'standard_id' => 'required',
    //     'subject_id' => 'required',
    //     'book_id' => 'required',
    //     'topic_id' => 'required',
    //     'title' => 'required',
    //     'tags' => 'required',
    //     'img' => 'file|mimes:jpeg,png,jpg',
    //     'about' => 'required',
    //     'src_type' => 'required',
    //     'file' => 'file',
    //     'url' => 'url',
    //     'creator' => 'required',
    //   ],
    //   'Ebook' => [
    //     'content_type_id' => 'required',
    //     'standard_id' => 'required',
    //     'subject_id' => 'required',
    //     'book_id' => 'required',
    //     'topic_id' => 'required',
    //     'title' => 'required',
    //     'tags' => 'required',
    //     'img' => 'file|mimes:jpeg,png,jpg',
    //     'about' => 'required',
    //     'src_type' => 'required',
    //     'file' => 'file',
    //     'url' => 'url',
    //     'price' => 'required',
    //   ]
    // };
  }
}
