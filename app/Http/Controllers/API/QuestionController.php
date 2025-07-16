<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TPG\AutomaticQuestionTypeResource;
use App\Http\Resources\TPG\TopicResource;
use App\Models\QuestionType;
use App\Models\Topic;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        // Automatic
        if (($request->has('topic_ids')) && ($request->has('type_ids')) && ($request->has('ques_selected'))) {
            $topicIds = explode(',', $request->topic_ids);
            $typeIds = explode(',', $request->type_ids);
            $quesSelected = explode(',', $request->ques_selected);

            $data = [];

            // 0
            foreach ($typeIds as $key => $typeId) {
                // Get the selected number of questions for this question type
                $limit = isset($quesSelected[$key]) ? $quesSelected[$key] : 0;

                // Retrieve the question type with its questions (filtered by topic and limited)
                $questionType = QuestionType::where('id', $typeId)
                    ->with(['questions' => function ($query) use ($topicIds, $limit) {
                        $query->whereIn('topic_id', $topicIds)
                            ->inRandomOrder()
                            ->limit($limit);
                    }])
                    ->first();

                if ($questionType) {
                    // Wrap the question type in the resource class (which groups the questions)
                    $data[] = new AutomaticQuestionTypeResource($questionType);
                }
            }

            // 1
            // foreach ($typeIds as $key => $typeId) {
            //     $question_types = QuestionType::with(['questions' => function ($query) use ($topicIds, $typeIds, $ques_selected, $key) {
            //         $query->whereIn('topic_id', $topicIds);
            //         $query->whereIn('question_type_id', $typeIds);
            //         $query->groupBy('question_type_id');
            //         $query->inRandomOrder();
            //         $query->limit($ques_selected[$key]);
            //     }])->get();
            //     array_push($data, AutomaticQuestionTypeResource::collection($question_types));
            // }

            // 2
            // foreach ($topicIds as $key => $topicId) {
            //     $topic = Topic::find($topicId);
            //     $question_types = QuestionType::with(['questions' => function ($query) use ($topicId, $typeIds, $ques_selected, $key) {
            //         $query->where('topic_id', $topicId);
            //         $query->whereIn('question_type_id', $typeIds);
            //         $query->inRandomOrder();
            //         $query->limit($ques_selected[$key]);
            //     }])->get();

            //     $topic = TopicResource::make($topic, $question_types);
            //     array_push($data, $topic);
            // }

            // 3
            // $data = collect($typeIds)->map(function ($typeId, $key) use ($topicIds, $ques_selected) {
            //     $type = QuestionType::find($typeId);
            //     $type->load(['questions' => function ($query) use ($topicIds, $ques_selected, $key) {
            //         $query->whereIn('topic_id', $topicIds)
            //             ->inRandomOrder()
            //             ->limit($ques_selected[$key]);
            //     }]);
            //     return new AutomaticQuestionTypeResource($type);
            // });

            return $this->sendAPIResponse($data, 'Questions fetched successfully.');
        }

        // Manual
        if ($request->has('topic_ids')) {
            $topicIds = explode(',', $request->topic_ids);

            $data = [];
            foreach ($topicIds as $key => $topicId) {
                $topic = Topic::find($topicId);
                $question_types = QuestionType::with(['questions' => function ($query) use ($topicId) {
                    $query->where('topic_id', $topicId);
                }])->get();
                // $topic->question_types = AutomaticQuestionTypeResource::collection($topic->question_types);
                $topic = TopicResource::make($topic, $question_types);
                array_push($data, $topic);
            }

            // $data = collect($topicIds)->map(function ($topicId) {
            //     $topic = Topic::with(['questionTypes' => function ($query) {
            //         $query->withCount('questions');
            //     }, 'questions' => function ($query) {
            //         $query->select('id', 'topic_id', 'question_type_id')
            //             ->orderBy('question_type_id');
            //     }])->find($topicId);

            //     return new TopicResource($topic);
            // });

            return $this->sendAPIResponse($data, 'Questions fetched successfully.');
        }
    }
}
