<?php

namespace App\Repositories;

use App\Repositories\Contracts\AuthorRepositoryInterface;
use App\Models\Author;

class AuthorRepository extends BaseRepository implements AuthorRepositoryInterface
{

    public $author;

    public function __construct(Author $author)
    {
        parent::__construct($author);
        $this->author = $author;
    }

    public function paginated($columns, $start, $length, $sortColumn, $sortDirection, $searchValue, $countOnly = false)
    {
        $query = $this->author->select('*');

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
        $authors = $query->get();
        $authors = $this->collectionModifier($columns, $authors, $start);
        return $authors;
    }

    public function collectionModifier($columns, $authors, $start)
    {
        return $authors->map(function ($author, $key) use ($columns, $start) {
            $author->serial = $start + 1 + $key;
            $author->actions = view('admin.authors.actions', compact('author'))->render();
            $author->setVisible($columns);
            return $author;
        });
    }
}
