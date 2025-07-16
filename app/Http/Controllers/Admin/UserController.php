<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public $user;

    public function __construct(UserRepository $userRepository)
    {
        $this->user = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role = Role::find($request->input('role'));
        session(['role' => $role->name]);

        return view('admin.users.index', compact('role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        $userDeletion = $user->delete();

        return $this->jsonResponse((bool) $userDeletion, 'User deleted successfully');
    }

    public function generateDataTableData($repository)
    {
        $role = session('role');
        $start = request()->get('start');
        $length = request()->get('length');
        $sortColumn = request()->get('order')[0]['name'] ?? 'id';
        $sortDirection = request()->get('order')[0]['dir'] ?? 'asc';
        $searchValue = request()->get('search')['value'];
        $columns = array_map(fn ($column) => $column['data'], request()->get('columns'));

        $count = $repository->paginated($columns, $role, $start, $length, $sortColumn, $sortDirection, $searchValue, true);
        $data = $repository->paginated($columns, $role, $start, $length, $sortColumn, $sortDirection, $searchValue);

        return $data = [
            'draw' => intval(request()->input('draw')),
            'recordsTotal' => intval($count),
            'recordsFiltered' => intval($count),
            'data' => $data,
        ];
    }

    public function dataTable()
    {
        $data = $this->generateDataTableData($this->user);

        return response()->json($data);
    }

    public function resetPassword(Request $request, User $user)
    {
        $user->password = Hash::make($user->email);
        $user->save();

        return response()->json(['message' => 'Password Reset Successful']);
    }

    public function approveUser(Request $request, User $user)
    {
        $request->validate([
            'books' => 'required',
        ], [
            'books.required' => 'Please select at least one book',
        ]);
        $user->assignBooks($request->books);
        $user->profile()->update(['status' => 'approved']);

        return response()->json(['message' => 'User Approved Successfully']);
    }

    public function rejectUser(Request $request, User $user)
    {
        $user->profile()->update(['status' => 'rejected']);

        return response()->json(['message' => 'User Rejected Successfully']);
    }

    public function extendTrial(Request $request, User $user)
    {
        $request->validate([
            'days' => 'required|integer|min:1',
        ]);

        $days = (int) $request->days;
        $profile = $user->profile;

        // If trial_end exists and is in the future, extend from that date
        // Otherwise, extend from now
        $newTrialEnd = $profile->trial_end && Carbon::parse($profile->trial_end)->isFuture()
            ? Carbon::parse($profile->trial_end)->addDays($days)
            : now()->addDays($days);

        $profile->update(['trial_end' => $newTrialEnd]);

        return response()->json([
            'message' => "Trial Extended Successfully till<br><strong>{$newTrialEnd->format('Y-m-d H:i:s')}</strong>",
        ]);
    }
}
