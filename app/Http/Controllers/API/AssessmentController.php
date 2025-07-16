<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttemptAssessmentRequest;
use App\Http\Resources\AssessmentsResource;
use App\Http\Resources\QuestionsResource;
use App\Http\Resources\ResultResource;
use App\Http\Resources\SubjectsResource;
use App\Models\Assessment;
use App\Models\Attempt;
use App\Models\Option;
use App\Models\Subject;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function mcq()
    {
        $subjects = Subject::all();
        $mcqAssessments = Assessment::where(['type' => 'mcq', 'standard_id' => Auth::user()->profile->standard_id])->latest()->get();

        $attemptedSeriesArr = Attempt::where('user_id', Auth::user()->id)->get()->pluck('assessment_id')->toArray();
        $attemptedMcqAssessments = Assessment::whereIn('id', $attemptedSeriesArr)->where('type', 'mcq')->latest()->get();

        return $this->sendAPIResponse([
            'newSeries' => AssessmentsResource::collection($mcqAssessments),
            'attemptedSeries' => AssessmentsResource::collection($attemptedMcqAssessments),
            'subjects' => SubjectsResource::collection($subjects),
        ], 'Assessments fetched successfully.');
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
        $olympiadAssessments = Assessment::where(['type' => 'olympiad', 'standard_id' => Auth::user()->profile->standard_id])->latest()->get();

        return $this->sendAPIResponse([
            'olympiads' => AssessmentsResource::collection($olympiadAssessments),
        ], 'Assessments fetched successfully.');
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
