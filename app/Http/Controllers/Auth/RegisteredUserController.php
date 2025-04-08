<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Standard;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Auth\UserRegistrationRequest;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    public function createTeacher(): View
    {
        $standards = Standard::all();
        return view('auth.teacher-registration', compact('standards'));
    }

    public function createStudent(): View
    {
        $standards = Standard::all();
        return view('auth.student-registration', compact('standards'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRegistrationRequest $request)
    {
        $attributes = $request->validated();

        // Check for existing user before starting transaction
        if (User::where('mobile', $attributes['mobile'])->exists()) {
            return back()->with('error', 'Mobile already exists. Please use a different mobile number.');
        }

        try {
            return DB::transaction(function () use ($request, $attributes) {
                // Parse standard IDs once
                $standardIdArr = is_array($attributes['standard_id']) ? $attributes['standard_id'] : explode(',', $attributes['standard_id']);

                // Validate code before user creation
                $validatedCode = $this->validateCode($attributes['code']);
                if (!$validatedCode) return back()->with('error', 'Registration failed, Invalid Code.');

                // Create user with minimal attributes
                $newUser = User::create([
                    'name' => $attributes['name'],
                    'mobile' => $attributes['mobile']
                ]);

                // Create profile
                $newUser->profile()->create([
                    'standard_id' => $standardIdArr[0],
                    'code_id' => $validatedCode->id,
                    'school_id' => $validatedCode->school->id,
                    // 'dob' => $attributes['dob'] ?? null,
                ]);

                // Assign standards
                $newUser->assignStandards($standardIdArr);

                // Assign role
                $newUser->assignRole($validatedCode->role->name);

                // Handle file upload if present
                if ($request->hasFile('img')) {
                    $uploadedFile = $this->uploadFile($request->file('img'), 'users/profile/img/');
                    $newUser->profile->img = $uploadedFile['name'];
                    $newUser->profile->save();
                }
                return back()->with('success', 'Registration successfull.');
            });
        } catch (\Exception $e) {
            // Log the exception with stack trace
            Log::error('User registration failed: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Registration failed, Please try again.');
        }
    }
}
