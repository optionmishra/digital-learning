<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideosResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->src_type == 'url' && preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $this->src, $match)) {
            return [
                'id' => $this->id,
                'title' => $this->title,
                'img' => $this->img_type === 'file' ? asset('contents/img/' . $this->img) : $this->img,
                'src' => $match[1],
                'url_type' => 'youtube',
                'duration' => $this->duration,
                'tags' => explode(',', $this->tags),
                'creator' => $this->creator,
                'about' => $this->about,
            ];
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'img' => $this->img_type === 'file' ? asset('contents/img/' . $this->img) : $this->img,
            'src' => $this->src_type === 'file' ? asset('contents/file/' . $this->src) : $this->src,
            'url_type' => 'other',
            'duration' => $this->duration,
            'tags' => explode(',', $this->tags),
            'creator' => $this->creator,
        ];
    }
}
