<?php

namespace App\Http\Controllers\API;

use App\Models\Topic;
use App\Models\Content;
use App\Models\Subject;
use App\Models\ContentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EbookResource;
use App\Http\Resources\VideoResource;
use App\Http\Resources\BannerResource;
use App\Http\Resources\ContentTypesResource;
use App\Http\Resources\EbooksResource;
use App\Http\Resources\VideosResource;
use App\Http\Resources\SubjectsResource;

class ContentController extends Controller
{
    // Videos
    public function getThreeRandomVideos()
    {
        $user = auth()->user();
        $videoContentType = ContentType::whereName('Video')->first();
        $videos = $videoContentType->classContents()->inRandomOrder()->limit(3)->get();
        return $this->sendAPIResponse([
            'banners' => BannerResource::make(null),
            'videos' => VideosResource::collection($videos),
            'subjects' => SubjectsResource::collection(Subject::all()),
        ], 'Videos fetched successfully.');
    }

    public function getVideosBySubjectId(string $id)
    {
        $videoContentType = ContentType::whereName('Video')->first();
        $videos = $videoContentType->classContents()->where('subject_id', $id)->get();
        if ($videos->count()) {
            return $this->sendAPIResponse(VideosResource::collection($videos), 'Videos fetched successfully.');
        }
        return $this->sendAPIError('Videos not found.');
    }

    public function showVideo(string $id)
    {
        $videoContentType = ContentType::whereName('Video')->first();
        $video = $videoContentType->contents()->find($id);
        if ($video) {
            return $this->sendAPIResponse(VideoResource::make($video), 'Video fetched successfully.');
        }
        return $this->sendAPIError('Video not found.');
    }

    // Ebooks
    public function getEbooksBySubjectId(string $id)
    {
        $ebookContentType = ContentType::whereName('Ebook')->first();
        $ebooks = $ebookContentType->classContents()->where('subject_id', $id)->get();
        if ($ebooks->count()) return $this->sendAPIResponse(EbooksResource::collection($ebooks), 'Ebooks fetched successfully.');

        return $this->sendAPIError('Ebooks not found.');
    }

    public function showEbook(string $id)
    {
        $ebookContentType = ContentType::whereName('Ebook')->first();
        $ebook = $ebookContentType->contents()->find($id);
        if ($ebook) return $this->sendAPIResponse(EbookResource::make($ebook), 'Ebook fetched successfully.');

        return $this->sendAPIError('Ebook not found.');
    }

    public function getContentTypesByTopicId($topicId)
    {
        $topic = Topic::find(
            $topicId
        );

        if (!$topic) return $this->sendAPIError('Topic not found.');

        return $this->sendAPIResponse(ContentTypesResource::collection($topic->uniqueAvailableContentTypes), 'Content Types fetched successfully.');
    }

    public function contentsByTopicIdAndTypeId(Request $request)
    {
        $contents = Content::where([
            'topic_id' => $request->topic,
            'content_type_id' => $request->content_type
        ])->get();

        return $this->sendAPIResponse(VideoResource::collection($contents), 'Contents fetched successfully.');
    }
}
