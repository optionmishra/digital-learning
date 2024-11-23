<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolutionsResource extends JsonResource
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
                'assessment_name' => $this->name,
                'attempted_on' => $this->latestAttempt->created_at->format('d M, Y'),
                'solutions' => AnswersResource::collection($this->questions),
            ];
        } else {
            return [
                'assessment_name' => $this->name,
                'solutions' => AnswersResource::collection($this->questions),
            ];
        }
    }
}
