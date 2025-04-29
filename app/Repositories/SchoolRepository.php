<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\School;
use App\Repositories\Contracts\BaseRepositoryInterface;

class SchoolRepository extends BaseRepository implements BaseRepositoryInterface
{

    public $school;

    public function __construct(School $school)
    {
        parent::__construct($school);
        $this->school = $school;
    }

    public function paginated($columns, $start, $length, $sortColumn, $sortDirection, $searchValue, $countOnly = false)
    {
        $query = $this->school->select('*');

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->orWhere('name', 'LIKE', "%$searchValue%");
                // ->orWhere('content', 'LIKE', "%$searchValue%");
                // ->orWhereHas('category', function ($q) use ($searchValue) {
                //     $q->where('title', 'LIKE', "%$searchValue%");
                // });
            });
        }

        if (!empty($sortColumn)) {
            switch (strtolower($sortColumn)) {
                case "#":
                    $sortColumn = 'id';
                    break;
                // case "category":
                //     $sortColumn = 'category_id';
                //     break;
                default:
                    $sortColumn = strtolower($sortColumn);
                    break;
            }
            $query->orderBy($sortColumn, $sortDirection);
        }

        $count = $query->count();

        if ($countOnly) {
            return $count;
        }

        $query->skip($start)->take($length);
        $schools = $query->get();
        $schools = $this->collectionModifier($columns, $schools, $start);
        return $schools;
    }

    public function collectionModifier($columns, $schools, $start)
    {
        // Get roles
        $roles = Role::whereIn('name', ['teacher', 'student'])->get()->keyBy('name');
        return $schools->map(function ($school, $key) use ($columns, $start, $roles) {
            $school->serial = $start + 1 + $key;
            $school->teacherCode = view('admin.schools.codes-count', ['school' => $school, 'role' => $roles['teacher']])->render();
            $school->studentCode = view('admin.schools.codes-count', ['school' => $school, 'role' => $roles['student']])->render();
            $school->actions = view('admin.schools.actions', compact('school'))->render();
            $school->setVisible($columns);
            return $school;
        });
    }
}
