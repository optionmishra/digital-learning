<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\McqSeriesResource;
use App\Models\Subject;
use App\Models\McqSeries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectsResource;

class McqController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        $mcqSeries = McqSeries::all()->sortByDesc('created_at');
        return $this->sendAPIResponse([
            'newSeries' => McqSeriesResource::collection($mcqSeries),
            'attemptedSeries' => [],
            'subjects' => SubjectsResource::collection($subjects)
        ], 'Series fetched successfully.');
    }

    public function getSeriesBySubject($id)
    {
        $mcqSeries = McqSeries::where('subject_id', $id)->get();
        if ($mcqSeries->count() == 0) {
            return $this->sendAPIResponse([], 'Series not found.');
        }
        return $this->sendAPIResponse(McqSeriesResource::collection($mcqSeries), 'Series fetched successfully.');
    }
}
