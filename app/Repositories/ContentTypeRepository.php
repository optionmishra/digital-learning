<?php

namespace App\Repositories;

use App\Models\ContentType;
use App\Repositories\Contracts\ContentTypeRepositoryInterface;

class ContentTypeRepository extends BaseRepository implements ContentTypeRepositoryInterface
{
    public $contentType;

    public function __construct(ContentType $contentType)
    {
        parent::__construct($contentType);
        $this->contentType = $contentType;
    }

    public function paginated($columns, $start, $length, $sortColumn, $sortDirection, $searchValue, $countOnly = false)
    {
        $query = $this->contentType->select('*');

        if (! empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->orWhere('name', 'LIKE', "%$searchValue%");
                // ->orWhere('content', 'LIKE', "%$searchValue%");
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
        $contentTypes = $query->get();
        $contentTypes = $this->collectionModifier($columns, $contentTypes, $start);

        return $contentTypes;
    }

    public function collectionModifier($columns, $contentTypes, $start)
    {
        return $contentTypes->map(function ($contentType, $key) use ($columns, $start) {
            $contentType->serial = $start + 1 + $key;
            // if ($contentType->media->first()) $contentType->media_file = view('admin.content_types.media', compact('contentType'))->render();
            $contentType->actions = view('admin.content_types.actions', compact('contentType'))->render();
            $contentType->setVisible($columns);

            return $contentType;
        });
    }
}
