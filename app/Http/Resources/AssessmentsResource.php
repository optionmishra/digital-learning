<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentsResource extends JsonResource
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
            'name' => $this->name,
            'subject' => $this->subject->name,
            'img' => $this->subject->img ? asset('subjects/img/'.$this->subject->img) : null,
            'questions_count' => $this->questions()->count(),
            'duration' => $this->duration,
        ];
    }
}
