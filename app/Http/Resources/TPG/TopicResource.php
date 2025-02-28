<?php

namespace App\Http\Resources\TPG;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TopicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    private $question_types;

    public function __construct($resource, $question_types = null)
    {
        $this->resource = $resource;
        $this->question_types = $question_types;
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'question_types' => $question_types ?? AutomaticQuestionTypeResource::collection($this->question_types),
        ];
    }
}
