<?php

namespace App\Http\Controllers\API;

use App\Models\Book;
use App\Models\Subject;
use App\Models\QuestionType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TopicResource;

class TopicController extends Controller
{
    public function getTopicsBySubjectId($subjectId)
    {
        $user = auth()->user();
        $book = Book::where([
            'series_id' => $user->series->id,
            'standard_id' => $user->standard->id,
            'subject_id' => $subjectId
        ])->first();

        if (!$book)
            return $this->sendAPIError('No books found for current subject & class');

        $topics = $book->topics;
        return $this->sendAPIResponse(TopicResource::collection($topics), 'Topics fetched successfully.');
    }

    public function getTopicsByBookId($bookId)
    {
        $book = Book::find($bookId);

        if (!$book) {
            return $this->sendAPIError('Book not found.');
        }

        $topics = $book->topics;

        return $this->sendAPIResponse($topics, 'Topics fetched successfully.');
    }

    public function getQuestionTypesByTopicIds(Request $request)
    {
        if (!$request->has('topic_ids')) {
            return $this->sendAPIError('Topic ids are required.');
        }

        $topicIds = explode(',', $request->topic_ids);

        $questionTypes = QuestionType::withCount(['questions' => function ($query) use ($topicIds) {
            $query->whereIn('topic_id', $topicIds);
        }])->get();

        return $this->sendAPIResponse($questionTypes, 'Question types fetched successfully.');
    }
}
