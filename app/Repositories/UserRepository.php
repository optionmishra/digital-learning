<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $user;

    public function __construct(User $user)
    {
        parent::__construct($user);
        $this->user = $user;
    }

    public function paginated($columns, $role = null, $start, $length, $sortColumn, $sortDirection, $searchValue, $countOnly = false)
    {

        $query = $this->user->with(['profile', 'schoolCode'])->select('*');


        if (!empty($role)) {
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        } else {
            $query->whereHas('roles', function ($q) {
                $q->where('name', 'user');
            });
        }


        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'LIKE', "%$searchValue%")
                    ->orWhere('email', 'LIKE', "%$searchValue%")
                    ->orWhere('mobile', 'LIKE', "%$searchValue%")
                    // ->orWhereHas('profile', function ($q2) use ($searchValue) {
                    //     $q2->where('school_id', 'LIKE', "%$searchValue%");
                    // })
                    ->orWhereHas('schoolCode', function ($q3) use ($searchValue) {
                        $q3->where('code_id', 'LIKE', "%$searchValue%");
                    });
            });
        }


        if (!empty($sortColumn)) {
            $sortColumn = strtolower($sortColumn) === '#' ? 'id' : strtolower($sortColumn);
            $sortDirection = strtolower($sortDirection) === 'asc' && strtolower($sortColumn) === 'id' ? 'DESC' : 'ASC';
            $query->orderBy($sortColumn == 'serial' ? 'id' : $sortColumn, $sortDirection);
        }


        if ($countOnly) {
            return $query->count();
        }


        $query->skip($start)->take($length);

        $users = $query->get();
        $users = $this->collectionModifier($users, $start, $role, $columns);

        return $users;
    }

    public static function collectionModifier($users, $start, $role, $columns)
    {
        return $users->map(function ($user, $key) use ($start, $role, $columns) {

            $user->serial = $start + 1 + $key;
            $user->school = $user->schoolName->name ?? 'N/A';
            $user->code = $user->schoolCode->code ?? 'N/A';
            $user->mobile = $user->mobile ?? 'N/A';


            $status = $user->profile->status ?? 'pending';
            switch ($status) {
                case 'approved':
                    $user->status = '<span class="p-1 rounded bg-success">' . ucfirst($status) . '</span>';
                    break;
                case 'pending':
                    $user->status = '<span class="p-1 rounded bg-warning">' . ucfirst($status) . '</span>';
                    break;
                case 'rejected':
                    $user->status = '<span class="p-1 rounded bg-danger">' . ucfirst($status) . '</span>';
                    break;
                default:
                    $user->status = '<span class="p-1 rounded bg-info">' . ucfirst($status) . '</span>';
            }


            $user->actions = view('admin.users.actions', compact('user'))->render();


            $user->setVisible($columns);

            return $user;
        });
    }
}
