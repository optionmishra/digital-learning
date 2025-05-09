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
use App\Models\Standard;

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
        $schools = School::all();
        $standards = Standard::all();

        // Get roles
        $roles = Role::whereIn('name', ['teacher', 'student'])->get()->keyBy('name');
        return view("admin.schools.index", compact('schools', 'standards', 'roles'));
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

                // // Get roles
                // $roles = Role::whereIn('name', ['teacher', 'student'])->get()->keyBy('name');

                // if (!$request->input('id') && $roles->has('teacher') && $roles->has('student')) {
                //     // Prepare codes data
                //     $codesData = [
                //         [
                //             'code' => substr(trim($school->name), 0, 5) . Str::random(5),
                //             'role_id' => $roles['teacher']->id,
                //         ],
                //         [
                //             'code' => substr(trim($school->name), 0, 5) . Str::random(5),
                //             'role_id' => $roles['student']->id,
                //         ]
                //     ];

                //     $school->codes()->createMany($codesData);
                // }

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

   //Kuldeep
    public function codesTable(Request $request, School $school, $role_id)
    {
        $codes = $school->codes()
            ->where('role_id', $role_id)
            ->with('standards') // eager load standards
            ->get()
            ->map(function ($code) {
              return [
                 'code' => $code->code,
                  'standard' => $code->standards->pluck('name')->implode(', ')
            ];
         });

        return view('admin.schools.codes-table', compact('codes'));
    }


    public function storeCode(Request $request, $role_id)
    {
        $school = School::find($request->input('school'));
        $standardIdArr = $request->input('standards');
        $str = $school->name;
        $count = 0;
        $schoolName = "";

        for ($i = 0; $i < strlen($str); $i++) {
            if ($str[$i] !== ' ') {
                $schoolName .= $str[$i];
                $count++;
                if ($count === 5) {
                    break;
                }
            }
        }

        try {
            return DB::transaction(function () use ($request, $school, $schoolName, $standardIdArr, $role_id) {

                // Get roles
                $roles = Role::whereIn('name', ['teacher', 'student'])->get()->keyBy('name');

                $codesData = [
                    'code' => substr($schoolName, 0, 5) . Str::random(5),
                    'role_id' => $role_id,
                ];

                $code = $school->codes()->create($codesData);
                $code->assignStandards($standardIdArr);

                return $this->jsonResponse(true, "Code created successfully");
            });
        } catch (\Exception $e) {
            // Log the error
            Log::error('Code creation failed: ' . $e->getMessage());
            return $this->jsonResponse(false, 'Failed to process code data', [], 500);
        }
    }
}
