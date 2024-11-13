<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
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
            'img' => $this->img_type === 'file' ? asset('contents/img/' . $this->img) : $this->img,
            'src' => $this->src_type === 'file' ? asset('contents/file/' . $this->src) : $this->src,
            'duration' => $this->duration,
            'tags' => explode(',', $this->tags),
            'creator' => $this->creator,
            'about' => $this->about,
        ];
    }
}
