<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
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
            'title' => $this->title,
            'src' => $this->src_type === 'file' ? asset('contents/file/'.$this->src) : $this->src,
            'tags' => explode(',', $this->tags),
            'about' => $this->about,
        ];
    }
}
