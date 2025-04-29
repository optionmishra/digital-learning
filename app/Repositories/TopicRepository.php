<?php

namespace App\Repositories;

use App\Repositories\Contracts\TopicRepositoryInterface;
use App\Models\Topic;

class TopicRepository extends BaseRepository implements TopicRepositoryInterface
{

    public $topic;

    public function __construct(Topic $topic)
    {
        parent::__construct($topic);
        $this->topic = $topic;
    }

    public function paginated($columns, $start, $length, $sortColumn, $sortDirection, $searchValue, $countOnly = false)
    {
        $query = $this->topic->select('*');

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->orWhere('name', 'LIKE', "%$searchValue%");
                // ->orWhere('type', 'LIKE', "%$searchValue%");
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
        $topics = $query->get();
        $topics = $this->collectionModifier($columns, $topics, $start);
        return $topics;
    }

    public function collectionModifier($columns, $topics, $start)
    {
        return $topics->map(function ($topic, $key) use ($columns, $start) {
            $topic->serialNo = $topic->serial;
            $topic->actions = view('admin.topics.actions', compact('topic'))->render();
            $topic->serial = $start + 1 + $key;
            // $topic->image = view('admin.topics.media', compact('topic'))->render();
            $topic->subject_name = $topic->subject->name;
            $topic->book_name = $topic->book->name;
            $topic->setVisible($columns);
            return $topic;
        });
    }
}
