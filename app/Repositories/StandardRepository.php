<?php

namespace App\Repositories;

use App\Repositories\Contracts\StandardRepositoryInterface;
use App\Models\Standard;

class StandardRepository extends BaseRepository implements StandardRepositoryInterface
{

    public $standard;

    public function __construct(Standard $standard)
    {
        parent::__construct($standard);
        $this->standard = $standard;
    }

    public function paginated($columns, $start, $length, $sortColumn, $sortDirection, $searchValue, $countOnly = false)
    {
        $query = $this->standard->select('*');

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
        $standards = $query->get();
        $standards = $this->collectionModifier($columns, $standards, $start);
        return $standards;
    }

    public function collectionModifier($columns, $standards, $start)
    {
        return $standards->map(function ($standard, $key) use ($columns, $start) {
            $standard->serial = $start + 1 + $key;
            $standard->actions = view('admin.standards.actions', compact('standard'))->render();
            $standard->setVisible($columns);
            return $standard;
        });
    }
}
