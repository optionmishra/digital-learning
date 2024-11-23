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
