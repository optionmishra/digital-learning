<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttemptAssessmentRequest;
use App\Http\Resources\AssessmentsResource;
use App\Http\Resources\QuestionsResource;
use App\Http\Resources\ResultResource;
use App\Models\Assessment;
use App\Models\Option;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function mcq(\Illuminate\Http\Request $request): \Illuminate\Http\JsonResponse
    {
        $query = Assessment::query()
            ->where('type', 'mcq')
            ->where('standard_id', Auth::user()->profile->standard_id);

        if ($request->has('subject_ids')) {
            $subjectIds = array_map('intval', array_filter(explode(',', $request->input('subject_ids'))));
            if (! empty($subjectIds)) {
                $query->whereIn('subject_id', $subjectIds);
            }
        }

        if ($request->has('series_ids')) {
            $seriesIds = array_map('intval', array_filter(explode(',', $request->input('series_ids'))));
            if (! empty($seriesIds)) {
                $query->whereIn('series_id', $seriesIds);
            }
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%'.$request->input('search').'%');
        }

        $mcqAssessments = $query->latest()->get();

        if ($mcqAssessments->isEmpty()) {
            return $this->sendAPIResponse([], 'Assessments not found.');
        }

        return $this->sendAPIResponse(AssessmentsResource::collection($mcqAssessments), 'Assessments fetched successfully.');
    }

    public function getMcqAssessmentBySubjectId($id)
    {
        $mcqAssessment = Assessment::where(['subject_id' => $id, 'type' => 'mcq', 'standard_id' => Auth::user()->profile->standard_id])->latest()->get();
        if ($mcqAssessment->count() == 0) {
            return $this->sendAPIResponse([], 'Assessment not found.');
        }

        return $this->sendAPIResponse(AssessmentsResource::collection($mcqAssessment), 'Assessments fetched successfully.');
    }

    public function olympiad()
    {
        $query = Assessment::query()
            ->where('type', 'olympiad')
            ->where('standard_id', Auth::user()->profile->standard_id);

        if ($request->has('subject_ids')) {
            $subjectIds = array_map('intval', array_filter(explode(',', $request->input('subject_ids'))));
            if (! empty($subjectIds)) {
                $query->whereIn('subject_id', $subjectIds);
            }
        }

        if ($request->has('series_ids')) {
            $seriesIds = array_map('intval', array_filter(explode(',', $request->input('series_ids'))));
            if (! empty($seriesIds)) {
                $query->whereIn('series_id', $seriesIds);
            }
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%'.$request->input('search').'%');
        }

        $olympiadAssessments = $query->latest()->get();

        if ($olympiadAssessments->isEmpty()) {
            return $this->sendAPIResponse([], 'Assessments not found.');
        }

        return $this->sendAPIResponse(AssessmentsResource::collection($olympiadAssessments), 'Assessments fetched successfully.');
    }

    public function getOlympiadAssessmentBySubjectId($id)
    {
        $olympiadAssessment = Assessment::where(['subject_id' => $id, 'type' => 'olympiad', 'standard_id' => Auth::user()->profile->standard_id])->latest()->get();
        if ($olympiadAssessment->count() == 0) {
            return $this->sendAPIResponse([], 'Assessment not found.');
        }

        return $this->sendAPIResponse(AssessmentsResource::collection($olympiadAssessment), 'Assessments fetched successfully.');
    }

    public function getQuestionsByAssessmentId($id)
    {
        $assessment = Assessment::where('id', $id)->first();

        if (! $assessment) {
            return $this->sendAPIError('Assessment not found.');
        }

        $Questions = $assessment->questions()->get();

        if ($Questions->count() == 0) {
            return $this->sendAPIResponse([], 'Assessment not found.');
        }

        return $this->sendAPIResponse(QuestionsResource::collection($Questions), 'Questions fetched successfully.');
    }

    public function attemptAssessment(AttemptAssessmentRequest $attemptAssessmentRequest)
    {
        $assessmentId = $attemptAssessmentRequest->assessment_id;
        $assessment = Assessment::find($assessmentId);

        if (! $assessment) {
            return $this->sendAPIError('Assessment not found.');
        }

        $user = Auth::user();
        $attempt = $user->attempts()->create([
            'assessment_id' => $assessmentId,
            'time_taken' => $attemptAssessmentRequest->time_taken,
        ]);

        // Ensure clean and filtered arrays of integers
        $questionsArr = array_map('intval', array_filter(array_map('trim', explode(',', $attemptAssessmentRequest->questions))));
        $answersArr = array_map('intval', array_filter(array_map('trim', explode(',', $attemptAssessmentRequest->answers))));

        $submissionsData = []; // Array to hold bulk insert data
        $totalQuestions = $assessment->questions()->count();
        $correctAnswers = 0;
        $incorrectAnswers = 0;

        // Ensure questions and answers arrays have the same count
        if (count($questionsArr) === count($answersArr)) {
            foreach ($questionsArr as $index => $questionId) {
                $submissionsData[] = [
                    'user_id' => $user->id,
                    'attempt_id' => $attempt->id,
                    'question_id' => $questionId,
                    'option_id' => $answersArr[$index],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $option = Option::find($answersArr[$index]);
                if ($option && $option->is_correct) {
                    $correctAnswers++;
                } else {
                    $incorrectAnswers++;
                }
            }

            // Insert all submissions at once to optimize performance
            Submission::insert($submissionsData);

            $result = $attempt->result()->create([
                'total_questions' => $totalQuestions,
                'correct_answers' => $correctAnswers,
                'incorrect_answers' => $incorrectAnswers,
                'score' => ($correctAnswers / $totalQuestions) * 100,
            ]);
        } else {
            // Handle mismatch in the count of questions and answers
            return $this->sendAPIResponse(['error' => 'Questions and answers count do not match.'], 400);
        }

        return $this->sendAPIResponse(['result' => ResultResource::make($result)], 'Assessment attempted successfully.');
    }
}
