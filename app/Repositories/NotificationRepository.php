<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Repositories\Contracts\NotificationRepositoryInterface;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    public $notification;

    public function __construct(Notification $notification)
    {
        parent::__construct($notification);
        $this->notification = $notification;
    }

    public function paginated($columns, $start, $length, $sortColumn, $sortDirection, $searchValue, $countOnly = false)
    {
        $query = $this->notification->select('*');

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
        $notifications = $query->get();
        $notifications = $this->collectionModifier($columns, $notifications, $start);

        return $notifications;
    }

    public function collectionModifier($columns, $notifications, $start)
    {
        return $notifications->map(function ($notification, $key) use ($columns, $start) {
            $notification->serial = $start + 1 + $key;
            $notification->status = $notification->is_active ? 'Active' : 'Inactive';
            $notification->actions = view('admin.notifications.actions', compact('notification'))->render();
            $notification->setVisible($columns);

            return $notification;
        });
    }
}
