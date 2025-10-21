<?php

namespace App\Http\Resources\TPG;

use App\Http\Resources\QuestionsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AutomaticQuestionTypeResource extends JsonResource
{
    private $questions;

    public function __construct($resource, $questions = null)
    {
        $this->resource = $resource;
        $this->questions = $questions;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // if ($this->questions) {
        //   return [
        //     'id' => $this->id,
        //     'name' => $this->name,
        //     'questions_count' => $this->when(isset($this->questions_count), $this->questions_count),
        //     'questions' => $this->questions ? QuestionsResource::collection($this->questions) : null,
        //   ];
        // }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'questions_count' => $this->when(isset($this->questions_count), $this->questions_count),
            'questions' => QuestionsResource::collection($this->whenLoaded('questions')),
        ];
    }
}
