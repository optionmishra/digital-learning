<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EbooksResource extends JsonResource
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
            'thumbnail' => $this->img_type === 'file' ? asset('contents/img/' . $this->img) : $this->img,
            'src' => $this->src_type === 'file' ? asset('contents/file/' . $this->src) : $this->src,
            'price' => $this->price,
            'tags' => explode(',', $this->tags),
        ];
    }
}
