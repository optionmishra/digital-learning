<?php

namespace App\Repositories;

use App\Repositories\Contracts\SubjectRepositoryInterface;
use App\Models\Subject;

class SubjectRepository extends BaseRepository implements SubjectRepositoryInterface
{

    public $subject;

    public function __construct(Subject $subject)
    {
        parent::__construct($subject);
        $this->subject = $subject;
    }

    public function paginated($start, $length, $sortColumn, $sortDirection, $searchValue, $countOnly = false)
    {
        $query = $this->subject->select('*');

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->orWhere('title', 'LIKE', "%$searchValue%")
                    ->orWhere('content', 'LIKE', "%$searchValue%");
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
        $subjects = $query->get();
        $subjects = $this->collectionModifier($subjects, $start);
        return $subjects;
    }

    public function collectionModifier($subjects, $start)
    {
        return $subjects->map(function ($subject, $key) use ($start) {
            $subject->serial = $start + 1 + $key;
            if ($subject->media->first()) $subject->media_file = view('admin.subjects.media', compact('subject'))->render();
            $subject->actions = view('admin.subjects.actions', compact('subject'))->render();
            $subject->setHidden(['id', 'created_at', 'updated_at', 'media']);
            return $subject;
        });
    }
}
