<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'question_text' => $this->question_text,
            'question_img' => $this->question_img ? asset('questions/'.$this->question_img) : null,
            'options' => OptionsResource::collection($this->options),
            'correct_option' => OptionsResource::make($this->options->where('is_correct', true)->first()),
        ];
    }
}
