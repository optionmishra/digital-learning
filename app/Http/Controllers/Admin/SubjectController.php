<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubjectRequest;
use App\Models\Subject;
use App\Repositories\SubjectRepository;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public $subject;

    public function __construct(SubjectRepository $subjectRepository)
    {
        $this->subject = $subjectRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.subjects.index');
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
    public function store(StoreSubjectRequest $request)
    {
        $data = $request->validated();
        $subject = $this->subject->store($data, $request->input('id'));

        return $this->jsonResponse((bool) $subject, 'Subject '.($request->input('id') ? 'updated' : 'created').' successfully');
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
    public function destroy(Request $request, Subject $subject)
    {
        $subjectDeletion = $subject->delete();

        return $this->jsonResponse((bool) $subjectDeletion, 'Subject deleted successfully');
    }

    public function dataTable()
    {
        $data = $this->generateDataTableData($this->subject);

        return response()->json($data);
    }
}
