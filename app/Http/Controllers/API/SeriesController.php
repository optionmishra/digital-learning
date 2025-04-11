<?php

namespace App\Http\Controllers\API;

use App\Models\Series;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectsResource;

class SeriesController extends Controller
{
    public function index()
    {
        $series = Series::all();
        return $this->sendAPIResponse(SubjectsResource::collection($series), 'Series fetched successfully.');
    }
}
