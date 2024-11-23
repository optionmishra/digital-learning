<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'assessment_name' => $this->assessment->name,
            'attempted_on' => $this->attempt->created_at->format('d M, Y'),
            'correct_percentage' => $this->correct_answers / $this->total_questions * 100 . '%',
            'incorrect_percentage' => $this->incorrect_answers / $this->total_questions * 100 . '%',
            'accuracy' => $this->correct_answers / $this->total_questions * 100 . '%',
            'total_questions_attempted' => $this->correct_answers + $this->incorrect_answers,
            'correct_answers' => $this->correct_answers,
            'incorrect_answers' => $this->incorrect_answers
        ];
    }
}
