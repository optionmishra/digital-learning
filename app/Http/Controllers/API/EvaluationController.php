<?php

namespace App\Http\Controllers\API;

use App\Models\Attempt;
use App\Models\Assessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AssessmentsResource;
use App\Http\Resources\ReportResource;
use App\Http\Resources\SolutionsResource;

class EvaluationController extends Controller
{
    public function scoreIndex()
    {
        $attemptedAssessmentsArr = Attempt::select('assessment_id', DB::raw('max(created_at) as latest_attempt'))
            ->where('user_id', Auth::user()->id)
            ->groupBy('assessment_id')
            ->orderBy('latest_attempt', 'desc')
            ->pluck('assessment_id')->toArray();

        $attemptedMcqAssessments = Assessment::whereIn('id', $attemptedAssessmentsArr)->where('type', 'mcq')->latest()->get();
        $attemptedOlympiadAssessments = Assessment::whereIn('id', $attemptedAssessmentsArr)->where('type', 'olympiad')->latest()->get();

        $mcqScoreSum = $attemptedMcqAssessments->sum(function ($assessment) {
            return $assessment->results()->where('user_id', Auth::user()->id)->latest('results.created_at')->value('score'); // Sum of scores for only the latest attempt of each assessment, for the current user
        });
        $mcqAttemptCount = $attemptedMcqAssessments->count();

        $olympiadScoreSum = $attemptedOlympiadAssessments->sum(function ($assessment) {
            return $assessment->results->sum('score');
        });
        $olympiadAttemptCount = $attemptedOlympiadAssessments->count();

        // $totalScoreSum = $mcqScoreSum + $olympiadScoreSum;
        // $totalAttemptCount = $mcqAttemptCount + $olympiadAttemptCount;

        return $this->sendAPIResponse(
            [
                'mcq' => [
                    'overallScore' => $mcqAttemptCount > 0 ? $mcqScoreSum / $mcqAttemptCount : 0,
                    'assessments' => AssessmentsResource::collection($attemptedMcqAssessments)
                ],
                'olympiad' => [
                    'overallScore' => $olympiadAttemptCount > 0 ? $olympiadScoreSum / $olympiadAttemptCount : 0,
                    'assessments' => AssessmentsResource::collection($attemptedOlympiadAssessments)
                ]
            ],
            'Scores fetched successfully.'
        );
    }

    public function getAttemptsBySubjectId(Request $request, $subject_id)
    {
        // Get the assessments attempted by the user in the specific subject
        $attemptDetails = Assessment::where('subject_id', $subject_id)
            ->when($request->type, fn($query, $type) => $query->where('type', $type))
            ->whereHas('attempts', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->with(['attempts' => function ($query) {
                $query->where('user_id', Auth::user()->id)
                    ->with(['result', 'submissions'])
                    ->latest();
            }])
            ->get()
            ->map(function ($assessment) {
                // Get the latest attempt for this assessment
                $latestAttempt = $assessment->attempts->first();

                if (!$latestAttempt) {
                    return null;
                }

                // Prepare the result details
                $result = $latestAttempt->result;

                return [
                    'id' => $assessment->id,
                    'assessment_name' => $assessment->name,
                    'attempt_details' => [
                        'total_questions' => $result->total_questions,
                        'attempted_questions' => $result->correct_answers + $result->incorrect_answers,
                        'correct_answers' => $result->correct_answers,
                        'incorrect_answers' => $result->incorrect_answers,
                        'score' => number_format($result->score, 2) . '%',
                    ],
                    'time_taken' => $latestAttempt->time_taken,
                    'total_duration' => $assessment->duration,
                ];
            })
            ->filter() // Remove null values
            ->values(); // Reset array keys

        return $this->sendAPIResponse([
            'attemptedSeries' => $attemptDetails,
        ], 'Attempted assessments fetched successfully.');
    }

    public function answerKeyIndex()
    {
        $mcqAssessments = Assessment::where(['type' => 'mcq', 'standard_id' => Auth::user()->profile->standard_id])->latest()->get();
        $olympiadAssessments = Assessment::where(['type' => 'olympiad', 'standard_id' => Auth::user()->profile->standard_id])->latest()->get();

        return $this->sendAPIResponse(
            [
                'mcqAssessments' => AssessmentsResource::collection($mcqAssessments),
                'olympiadAssessments' => AssessmentsResource::collection($olympiadAssessments)
            ],
            'Assessments fetched successfully.'
        );
    }

    public function report($id)
    {
        $attempt = Attempt::where('assessment_id', $id)->where('user_id', Auth::user()->id)->latest()->first();
        if ($attempt) {
            $report = $attempt->result;

            return $this->sendAPIResponse(ReportResource::make($report), 'Report fetched successfully.');
        }
        return $this->sendAPIError('Attempt not found.');
    }

    public function solutions($id)
    {
        $user = Auth::user();
        $assessment = Assessment::find($id);
        if ($user->hasRole('student')) {
            $attempt = Attempt::where('assessment_id', $id)->where('user_id', $user->id)->latest()->first();
            if ($attempt) {
                return $this->sendAPIResponse(SolutionsResource::make($assessment), 'Solutions fetched successfully.');
            }
            return $this->sendAPIError('Attempt not found.');
        } else {
            return $this->sendAPIResponse(SolutionsResource::make($assessment), 'Solutions fetched successfully.');
        }
    }
}
