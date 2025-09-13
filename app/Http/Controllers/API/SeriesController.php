<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\SeriesResource;
use App\Models\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Series::query();

        if ($request->has('subject_ids')) {
            $subjectIds = $request->input('subject_ids');

            // Handle comma-separated string or array input for subject_ids
            if (is_string($subjectIds)) {
                $subjectIds = explode(',', $subjectIds);
            }
            // Ensure all IDs are integers and filter out any non-numeric or empty values
            $subjectIds = array_filter(array_map('intval', (array) $subjectIds));

            // Assuming a many-to-many relationship named 'subjects' exists on the Series model
            // and we want to filter series that are associated with any of the given subject_ids.
            if (! empty($subjectIds)) {
                $query->whereIn('subject_id', $subjectIds);
            }
        }

        $series = $query->get();

        return $this->sendAPIResponse(SeriesResource::collection($series), 'Series fetched successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
