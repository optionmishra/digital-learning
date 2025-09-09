<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $adminsCount = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->count();
        $teachersCount = User::whereHas('roles', function ($query) {
            $query->where('name', 'teacher');
        })->count();
        $studentsCount = User::whereHas('roles', function ($query) {
            $query->where('name', 'student');
        })->count();

        return view('admin.dashboard.index', compact('adminsCount', 'teachersCount', 'studentsCount'));
    }
}
