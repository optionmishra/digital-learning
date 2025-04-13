<?php

namespace App\Repositories;

use App\Repositories\Contracts\SeriesRepositoryInterface;
use App\Models\Series;

class SeriesRepository extends BaseRepository implements SeriesRepositoryInterface
{

    public $series;

    public function __construct(Series $series)
    {
        parent::__construct($series);
        $this->series = $series;
    }

    public function paginated($columns, $start, $length, $sortColumn, $sortDirection, $searchValue, $countOnly = false)
    {
        $query = $this->series->select('*');

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
        $seriess = $query->get();
        $seriess = $this->collectionModifier($columns, $seriess, $start);
        return $seriess;
    }

    public function collectionModifier($columns, $seriess, $start)
    {
        return $seriess->map(function ($series, $key) use ($columns, $start) {
            $series->serial = $start + 1 + $key;
            // if ($series->media->first()) $series->media_file = view('admin.seriess.media', compact('series'))->render();
            $series->actions = view('admin.series.actions', compact('series'))->render();
            $series->setVisible($columns);
            return $series;
        });
    }
}
