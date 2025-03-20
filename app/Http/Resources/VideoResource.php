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
        $urlType = 'other';
        $src = $this->src;

        if ($this->src_type === 'url') {
            // Check for YouTube video
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $this->src, $match)) {
                $src = $match[1];
                $urlType = 'youtube';
            }
            // Check for Vimeo video
            elseif (preg_match('~^https?://(?:www\.)?vimeo\.com/(?:channels/(?:\w+/)?|groups/([^/]*)/videos/|)(\d+)(?:|/\?)~', $this->src, $match)) {
                $urlType = 'vimeo';
            }
        } else if ($this->src_type === 'file') {
            $src = asset('contents/file/' . $this->src);
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'topic' => TopicResource::make($this->topic),
            'img' => $this->img_type === 'file' ? asset('contents/img/' . $this->img) : $this->img,
            'src' => $src,
            'url_type' => $urlType,
            'duration' => $this->duration,
            'tags' => explode(',', $this->tags),
            'creator' => $this->creator,
            'about' => $this->about,
        ];
    }
}
