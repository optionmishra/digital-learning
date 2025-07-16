<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssessmentRequest;
use App\Models\Assessment;
use App\Models\Book;
use App\Models\Standard;
use App\Models\Subject;
use App\Repositories\AssessmentRepository;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public $assessment;

    public function __construct(AssessmentRepository $assessment)
    {
        $this->assessment = $assessment;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $standards = Standard::all();
        $subjects = Subject::all();
        $books = Book::all();

        return view('admin.assessments.index', compact('standards', 'subjects', 'books'));
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
    public function store(StoreAssessmentRequest $request)
    {
        $data = $request->validated();
        $assessment = $this->assessment->store($data, $request->input('id'));

        return $this->jsonResponse((bool) $assessment, 'Assessment '.($request->input('id') ? 'updated' : 'created').' successfully');
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
    public function destroy(Request $request, Assessment $assessment)
    {
        $assessmentDeletion = $assessment->delete();

        return $this->jsonResponse((bool) $assessmentDeletion, 'Assessment deleted successfully');
    }

    public function dataTable()
    {
        $data = $this->generateDataTableData($this->assessment);

        return response()->json($data);
    }
}
