<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = auth()->user();
        if ($user->hasRole('student')) {
            return [
                'id' => $this->id,
                'question_text' => $this->question_text,
                'options' => OptionsResource::collection($this->options),
                'correct_option' => OptionsResource::make($this->options->where('is_correct', true)->first()),
                'submitted_option' => OptionsResource::make($this->userSubmittedOption),
            ];
        } else {
            return [
                'id' => $this->id,
                'question_text' => $this->question_text,
                'options' => OptionsResource::collection($this->options),
                'correct_option' => OptionsResource::make($this->options->where('is_correct', true)->first()),
            ];
        }
    }
}
