<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total_questions' => $this->total_questions,
            'correct_answers' => $this->correct_answers,
            'incorrect_answers' => $this->incorrect_answers,
            'score' => $this->score . '%',
        ];
    }
}
