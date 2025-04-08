<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\School;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\SchoolRepository;
use App\Http\Requests\StoreSchoolRequest;

class SchoolController extends Controller
{
    public $school;

    public function __construct(SchoolRepository $schoolRepository)
    {
        $this->school = $schoolRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.schools.index");
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
    public function store(StoreSchoolRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $data = $request->validated();
                $school = $this->school->store($data, $request->input('id'));

                // Get roles
                $roles = Role::whereIn('name', ['teacher', 'student'])->get()->keyBy('name');

                if (!$request->input('id') && $roles->has('teacher') && $roles->has('student')) {
                    // Prepare codes data
                    $codesData = [
                        [
                            'code' => Str::random(10),
                            'role_id' => $roles['teacher']->id,
                        ],
                        [
                            'code' => Str::random(10),
                            'role_id' => $roles['student']->id,
                        ]
                    ];

                    $school->codes()->createMany($codesData);
                }

                $action = $request->input('id') ? 'updated' : 'created';
                return $this->jsonResponse(true, "School {$action} successfully");
            });
        } catch (\Exception $e) {
            // Log the error
            Log::error('School creation failed: ' . $e->getMessage());
            return $this->jsonResponse(false, 'Failed to process school data', [], 500);
        }
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
    public function destroy(Request $request, School $school)
    {
        $schoolDeletion = $school->delete();
        return $this->jsonResponse((bool)$schoolDeletion, 'School deleted successfully');
    }

    public function dataTable()
    {
        $data = $this->generateDataTableData($this->school);
        return response()->json($data);
    }
}
