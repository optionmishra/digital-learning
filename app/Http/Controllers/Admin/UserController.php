<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Restriction;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public $user;
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }


    public function index()
    {
        $users = $this->user->findAll();
        return view('admin.users.index', compact('users'));
    }

    public function datatable()
    {
        $start = request()->get('start');
        $length = request()->get('length');
        $sortColumn = request()->get('order')[0]['name'] ?? 'id';
        $sortDirection = request()->get('order')[0]['dir'] ?? 'asc';
        $searchValue = request()->get('search')['value'];

        $count = $this->user->paginated($start, $length, $sortColumn, $sortDirection, $searchValue, true);
        $users = $this->user->paginated($start, $length, $sortColumn, $sortDirection, $searchValue);

        $data = array(
            "draw"            => intval(request()->input('draw')),
            "recordsTotal"    => intval($count),
            "recordsFiltered" => intval($count),
            "data"            => $users
        );

        return response()->json($data);
    }

    public function destroy($id)
    {
        $this->user->delete($id);
        return response()->json(['error' => 0, 'message' => 'User deleted successfully']);
    }

    public function resetPassword(Request $request, User $user)
    {
        $user->password = Hash::make($user->email);
        $user->save();

        return response()->json(['message' => 'Password Reset Successful']);
    }

    public function mute(Request $request, User $user)
    {
        $permissionNames = ['can_post', 'can_comment', 'can_reply'];
        $permissionIds = Permission::whereIn('name', $permissionNames)->pluck('id')->toArray();

        if (empty($permissionIds)) {
            return response()->json(['error' => 1, 'message' => 'Permissions not found'], 404);
        }

        $user->restrictions()->sync($permissionIds, false);
        return response()->json(['message' => 'User muted successfully']);
    }

    public function unMute(Request $request, User $user)
    {
        $permissionNames = ['can_post', 'can_comment', 'can_reply'];
        $permissionIds = Permission::whereIn('name', $permissionNames)->pluck('id')->toArray();

        if (empty($permissionIds)) {
            return response()->json(['error' => 1, 'message' => 'Permissions not found'], 404);
        }

        $user->restrictions()->detach($permissionIds);
        return response()->json(['message' => 'User unmuted successfully']);
    }
}
