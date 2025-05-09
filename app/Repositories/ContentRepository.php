<?php

namespace App\Repositories;

use App\Repositories\Contracts\ContentRepositoryInterface;
use App\Models\Content;

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
        //  Eager load standard and subject
        $query = $this->content->with(['standard', 'subject'])->select('*');
        $query->where('content_type_id', 'LIKE', $type);

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->orWhere('title', 'LIKE', "%$searchValue%");
            });
        }

        if (!empty($sortColumn)) {
            switch (strtolower($sortColumn)) {
                case "#":
                    $sortColumn = 'id';
                    break;
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
            $content->serial = $start + $key + 1;
            //  Show class (standard name)
            $content->class = optional($content->standard)->name;
        

            //  Show subject name
            $content->subject = optional($content->subject)->name;
            
            
        
            

            $content->image = $content->img ? view('admin.contents.media', compact('content'))->render() : '';
            $content->url = view('admin.contents.url', compact('content'))->render();
            $content->actions = view('admin.contents.actions', compact('content'))->render();

            $content->setVisible($columns);
            return $content;
        });
    }
}
