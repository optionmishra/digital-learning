<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Http\Resources\EbookResource;
use App\Http\Resources\EbooksResource;
use App\Http\Resources\SubjectsResource;
use App\Http\Resources\TeacherResource;
use App\Http\Resources\VideoResource;
use App\Http\Resources\VideosResource;
use App\Models\Content;
use App\Models\ContentType;
use App\Models\Subject;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    // Videos
    public function indexVideos(Request $request)
    {

        $videoContentType = ContentType::whereName('Video')->first();
        $query = $videoContentType->classContents();

        // Apply filters
        if ($request->has('subject_ids')) {
            $query->whereIn('subject_id', explode(',', $request->subject_ids));
        }

        if ($request->has('series_ids')) {
            $query->whereIn('series_id', explode(',', $request->series_ids));
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        $videos = $query->get();

        return $this->sendAPIResponse(
            VideosResource::collection($videos),
            'Videos fetched successfully.'
        );
    }

    public function getThreeRandomVideos()
    {
        $videoContentType = ContentType::whereName('Video')->first();
        $videos = $videoContentType
            ->classContents()
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return $this->sendAPIResponse(
            [
                'banners' => BannerResource::make(null),
                'videos' => VideosResource::collection($videos),
                'subjects' => SubjectsResource::collection(Subject::all()),
            ],
            'Videos fetched successfully.'
        );
    }

    public function getVideosBySubjectId(string $id)
    {
        $videoContentType = ContentType::whereName('Video')->first();
        $videos = $videoContentType
            ->classContents()
            ->where('subject_id', $id)
            ->get();
        if ($videos->count()) {
            return $this->sendAPIResponse(
                VideosResource::collection($videos),
                'Videos fetched successfully.'
            );
        }

        return $this->sendAPIError('Videos not found.');
    }

    public function showVideo(string $id)
    {
        $videoContentType = ContentType::whereName('Video')->first();
        $video = $videoContentType->contents()->find($id);
        if ($video) {
            return $this->sendAPIResponse(
                VideoResource::make($video),
                'Video fetched successfully.'
            );
        }

        return $this->sendAPIError('Video not found.');
    }

    // Ebooks
    public function indexEbooks(Request $request)
    {

        $ebookContentType = ContentType::whereName('E-Book \ Flipbook')->first();
        $query = $ebookContentType->classContents();

        // Apply filters
        if ($request->has('subject_ids')) {
            $query->whereIn('subject_id', explode(',', $request->subject_ids));
        }

        if ($request->has('series_ids')) {
            $query->whereIn('series_id', explode(',', $request->series_ids));
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        $ebooks = $query->get();

        return $this->sendAPIResponse(
            EbooksResource::collection($ebooks),
            'Ebooks fetched successfully.'
        );
    }

    public function getEbooksBySubjectId(string $id)
    {
        $ebookContentType = ContentType::whereName(
            "E-Book \ Flipbook"
        )->first();
        $ebooks = $ebookContentType
            ->classContents()
            ->where('subject_id', $id)
            ->get();
        if ($ebooks->count()) {
            return $this->sendAPIResponse(
                EbooksResource::collection($ebooks),
                'Ebooks fetched successfully.'
            );
        }

        return $this->sendAPIError('Ebooks not found.');
    }

    public function showEbook(string $id)
    {
        $ebookContentType = ContentType::whereName(
            "E-Book \ Flipbook"
        )->first();
        $ebook = $ebookContentType->contents()->find($id);
        if ($ebook) {
            return $this->sendAPIResponse(
                EbookResource::make($ebook),
                'Ebook fetched successfully.'
            );
        }

        return $this->sendAPIError('Ebook not found.');
    }

    public function teacherResource(Request $request): \Illuminate\Http\JsonResponse
    {
        $answerKeyContentType = ContentType::whereName('Answer key')->first();
        $worksheetContentType = ContentType::whereName('Worksheet')->first();

        // Initialize query builders
        $answerKeysQuery = $answerKeyContentType ? $answerKeyContentType->classContents() : null;
        $worksheetsQuery = $worksheetContentType ? $worksheetContentType->classContents() : null;

        // Apply filters to Answer Keys query
        if ($answerKeysQuery) {
            if ($request->has('standard_ids')) {
                $answerKeysQuery->whereIn('standard_id', (array) $request->input('standard_ids'));
            }
            if ($request->has('subject_ids')) {
                $answerKeysQuery->whereIn('subject_id', (array) $request->input('subject_ids'));
            }
            if ($request->has('series_ids')) {
                $answerKeysQuery->whereIn('series_id', (array) $request->input('series_ids'));
            }
            if ($request->has('book_ids')) {
                $answerKeysQuery->whereIn('book_id', (array) $request->input('book_ids'));
            }
            if ($request->has('search')) {
                $answerKeysQuery->where('title', 'like', '%'.$request->search.'%');
            }
        }

        // Apply filters to Worksheets query
        if ($worksheetsQuery) {
            if ($request->has('standard_ids')) {
                $worksheetsQuery->whereIn('standard_id', (array) $request->input('standard_ids'));
            }
            if ($request->has('subject_ids')) {
                $worksheetsQuery->whereIn('subject_id', (array) $request->input('subject_ids'));
            }
            if ($request->has('series_ids')) {
                $answerKeysQuery->whereIn('series_id', (array) $request->input('series_ids'));
            }
            if ($request->has('book_ids')) {
                $worksheetsQuery->whereIn('book_id', (array) $request->input('book_ids'));
            }
            if ($request->has('search')) {
                $worksheetsQuery->where('title', 'like', '%'.$request->search.'%');
            }
        }

        // Get results or empty collection if content type was not found
        $answerKeys = $answerKeysQuery ? $answerKeysQuery->get() : collect();
        $worksheets = $worksheetsQuery ? $worksheetsQuery->get() : collect();

        return $this->sendAPIResponse(
            [
                'answer_keys' => TeacherResource::collection($answerKeys),
                'worksheets' => TeacherResource::collection($worksheets),
            ],
            'Teacher resources fetched successfully.'
        );
    }

    public function exercises()
    {

        $exerciseContentType = ContentType::whereName('Exercise')->first();
        $exercisesQuery = $exerciseContentType ? $exerciseContentType->classContents() : null;

        // Apply filters to Exercises query
        if ($exercisesQuery) {
            if ($request->has('standard_ids')) {
                $exercisesQuery->whereIn('standard_id', (array) $request->input('standard_ids'));
            }
            if ($request->has('subject_ids')) {
                $exercisesQuery->whereIn('subject_id', (array) $request->input('subject_ids'));
            }
            if ($request->has('series_ids')) {
                $exercisesQuery->whereIn('series_id', (array) $request->input('series_ids'));
            }
            if ($request->has('book_ids')) {
                $exercisesQuery->whereIn('book_id', (array) $request->input('book_ids'));
            }
            if ($request->has('search')) {
                $exercisesQuery->where('title', 'like', '%'.$request->search.'%');
            }
        }

        // Get results or empty collection if content type was not found
        $exercises = $exercisesQuery ? $exercisesQuery->get() : collect();

        return $this->sendAPIResponse(
            EbookResource::collection($exercises),
            'Exercises fetched successfully.'
        );
    }
}
