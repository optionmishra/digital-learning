<?php

namespace App\Repositories;

use App\Models\Content;
use App\Repositories\Contracts\ContentRepositoryInterface;

class ContentRepository extends BaseRepository implements ContentRepositoryInterface
{
    public $content;

    public function __construct(Content $content)
    {
        parent::__construct($content);
        $this->content = $content;
    }

    public function paginated($columns, $type, $start, $length, $sortColumn, $sortDirection, $searchValue, $countOnly = false)
    {
        $query = $this->content->select('*');
        $query->where('content_type_id', 'LIKE', $type);

        if (! empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->orWhere('title', 'LIKE', "%$searchValue%");
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
        $contents = $query->get();
        $contents = $this->collectionModifier($columns, $contents, $start);

        return $contents;
    }

    public function collectionModifier($columns, $contents, $start)
    {
        return $contents->map(function ($content, $key) use ($columns, $start) {
            $content->serial = $start + 1 + $key;
            $content->image = $content->img ? view('admin.contents.media', compact('content'))->render() : null;
            $content->url = $content->src ? view('admin.contents.url', compact('content'))->render() : null;
            $content->standard_name = $content->standard?->name;
            $content->subject_name = $content->subject?->name;
            $content->series_name = $content->series?->name;
            $content->actions = view('admin.contents.actions', compact('content'))->render();
            $content->setVisible($columns);

            return $content;
        });
    }
}
