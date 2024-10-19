<?php

namespace App\Repositories;

use App\Repositories\Contracts\BoardRepositoryInterface;
use App\Models\Board;

class BoardRepository extends BaseRepository implements BoardRepositoryInterface
{

    public $board;

    public function __construct(Board $board)
    {
        parent::__construct($board);
        $this->board = $board;
    }

    public function paginated($start, $length, $sortColumn, $sortDirection, $searchValue, $countOnly = false)
    {
        $query = $this->board->select('*');

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
        $boards = $query->get();
        $boards = $this->collectionModifier($boards, $start);
        return $boards;
    }

    public function collectionModifier($boards, $start)
    {
        return $boards->map(function ($board, $key) use ($start) {
            $board->serial = $start + 1 + $key;
            $board->actions = view('admin.boards.actions', compact('board'))->render();
            $board->setHidden(['id', 'created_at', 'updated_at']);
            return $board;
        });
    }
}
