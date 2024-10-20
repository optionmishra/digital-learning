<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->img ? asset('books/img/' . $this->img) : null,
            'about' => $this->about,
            'board' => $this->board ? $this->board->name : null,
            'standard' => $this->standard ? $this->standard->name : null,
            'subject' => $this->subject ? $this->subject->name : null,
            'author' => $this->author ? $this->author->name : null,
        ];
    }
}
