<?php

namespace App\Repositories;

use App\Models\Assessment;
use App\Repositories\Contracts\AssessmentRepositoryInterface;

class AssessmentRepository extends BaseRepository implements AssessmentRepositoryInterface
{
    public $assessment;

    public function __construct(Assessment $assessment)
    {
        parent::__construct($assessment);
        $this->assessment = $assessment;
    }

    public function paginated($columns, $start, $length, $sortColumn, $sortDirection, $searchValue, $countOnly = false)
    {
        $query = $this->assessment->select('*');

        if (! empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->orWhere('name', 'LIKE', "%$searchValue%")
                    ->orWhere('type', 'LIKE', "%$searchValue%");
                // ->orWhereHas('category', function ($q) use ($searchValue) {
                //     $q->where('title', 'LIKE', "%$searchValue%");
                // });
            });
        }

        if (! empty($sortColumn)) {
            switch (strtolower($sortColumn)) {
                case '#':
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
        $assessments = $query->get();
        $assessments = $this->collectionModifier($columns, $assessments, $start);

        return $assessments;
    }

    public function collectionModifier($columns, $assessments, $start)
    {
        return $assessments->map(function ($assessment, $key) use ($columns, $start) {
            $assessment->serial = $start + 1 + $key;
            // $assessment->image = view('admin.assessments.media', compact('assessment'))->render();
            $assessment->standard_name = $assessment->standard->name;
            $assessment->subject_name = $assessment->subject->name;
            $assessment->book_name = $assessment->book->name;
            $assessment->actions = view('admin.assessments.actions', compact('assessment'))->render();
            $assessment->setVisible($columns);

            return $assessment;
        });
    }
}
