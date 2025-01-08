<?php

namespace App\Repositories;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Models\User;
use PeterColes\Countries\CountriesFacade as Countries;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public $user;

    public function __construct(User $user)
    {
        parent::__construct($user);
        $this->user = $user;
    }

    public function paginated($columns, $role = null, $start,  $length, $sortColumn, $sortDirection, $searchValue, $countOnly = false)
    {
        $query = $this->user->select('*');

        // Filter by role if a role is provided
        if (!empty($role)) {
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('name', 'LIKE', "$role");
            });
        } else {
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('name', 'LIKE', "user");
            });
        }

        // Search logic
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->orWhere('name', 'LIKE', "%$searchValue%");
                $q->orWhere('email', 'LIKE', "%$searchValue%");
            });
        }

        // Sorting logic
        if (!empty($sortColumn)) {
            $sortColumn = strtolower($sortColumn) === '#' ? 'id' : strtolower($sortColumn);
            $sortDirection = strtolower($sortDirection) === 'asc' && strtolower($sortColumn) === 'id' ? 'DESC' : 'ASC';
            $query->orderBy($sortColumn, $sortDirection);
        }

        // Count
        $count = $query->count();

        if ($countOnly) {
            return $count;
        }

        // Pagination
        $query->skip($start)->take($length);
        $users = $query->get();
        $users = $this->collectionModifier($users, $start, $role, $columns);

        return $users;
    }

    public static function collectionModifier($users, $start, $role, $columns)
    {
        return $users->map(function ($user, $key) use ($start, $role, $columns) {
            $user->serial = $start + 1 + $key;
            // switch ($role) {
            //     case 'superadmin':
            //         // $user->actions = view('superadmin.superadmins.actions', compact('user'))->render();
            //         break;
            //     case 'admin':
            //         $user->actions = view('superadmin.admins.actions', compact('user'))->render();
            //         break;
            //     case 'user':
            //         $user->actions = view('superadmin.users.actions', compact('user'))->render();
            //         break;
            //     default:
            //     break;
            // }
            $user->actions = view('admin.users.actions', compact('user'))->render();
            $user->setVisible($columns);
            return $user;
        });
    }
}
