<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\StandardsResource;
use App\Models\Standard;
use Illuminate\Http\Request;

class StandardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $standards = Standard::where('status', true)->get();
        if (! $standards) {
            return $this->sendAPIResponse([], 'Standards not found.');
        }

        return $this->sendAPIResponse(StandardsResource::collection($standards), 'Standards fetched successfully.');
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
        $standard = Standard::find($id);
        if (! $standard) {
            return $this->sendAPIResponse([], 'Standard not found.');
        }

        return $this->sendAPIResponse(StandardsResource::make($standard), 'Standard fetched successfully.');
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

    public function getTeacherStandards()
    {
        $user = auth()->user();
        $standards = $user->standards;

        if (! $standards) {
            return $this->sendAPIResponse([], 'Standards not found.');
        }

        return $this->sendAPIResponse(StandardsResource::collection($standards), 'Standards fetched successfully.');
    }

    public function setTeacherStandard(Request $request)
    {
        request()->validate(['standard_id' => 'required']);
        $user = auth()->user();
        if ($user->hasRole('teacher')) {
            $user->profile->standard_id = $request->standard_id;
            $user->profile->save();

            return $this->sendAPIResponse(['subjects' => $user->subjects], 'Standard set successfully.');
        }

        return $this->sendAPIError('You are not a teacher.', [], 401);
    }
}
