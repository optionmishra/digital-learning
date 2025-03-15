<?php

namespace App\Http\Resources;

use App\Models\Subject;
use App\Models\ContentType;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\BannerResource;
use App\Http\Resources\VideosResource;
use App\Http\Resources\SubjectsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AppLoginResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $videoContentType = ContentType::whereName('Video')->first();
        $videos = $videoContentType->classContents()->take(5)->get();

        return [
            'user' => UserResource::make($this),
            'banners' => BannerResource::make(null),
            'videos' => VideosResource::collection($videos),
            'standards' => StandardsResource::collection($this->standards),
            'subjects' => SubjectsResource::collection($this->subjects),
            'books' => BooksResource::collection($this->books),
        ];
    }
}
