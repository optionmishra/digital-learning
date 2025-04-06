<?php

namespace App\Http\Controllers\API;

use App\Models\Code;
use App\Models\User;
use App\Models\Content;
use App\Models\Subject;
use App\Models\ContentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BannerResource;
use App\Http\Resources\VideosResource;
use App\Http\Resources\SubjectsResource;
use App\Http\Resources\UserProfileResource;
use App\Http\Requests\Auth\UserRegistrationRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\UserProfileUpdateRequest;
use App\Http\Resources\AppLoginResponseResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(UserRegistrationRequest $request)
    {
        $attributes = $request->validated();

        // Check for existing user before starting transaction
        if (User::where('mobile', $attributes['mobile'])->exists()) {
            return $this->sendAPIError('Mobile already exists.', ['error' => 'Mobile already exists.']);
        }

        try {
            return DB::transaction(function () use ($request, $attributes) {
                // Parse standard IDs once
                $standardIdArr = explode(',', $attributes['standard_id']);

                // Validate code before user creation
                $validatedCode = $this->validateCode($attributes['code']);
                if (!$validatedCode) return $this->sendAPIError('Invalid Code', 'Invalid Code');

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

                // Authenticate user
//                Auth::once($request->only('mobile'));
                Auth::login($newUser);

                return $this->sendAPIResponse([
                    AppLoginResponseResource::make($newUser),
                ], 'User registered successfully.');
            });
        } catch (\Exception $e) {
            // Log the exception with stack trace
            Log::error('User registration failed: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            return $this->sendAPIError('Registration failed. Please try again.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('mobile');
        $user = User::where($credentials)->first();

        if (!$user) {
            return $this->sendAPIError('User not found.', ['error' => 'User not found']);
        }

        Auth::login($user);

        return $this->sendAPIResponse([
            AppLoginResponseResource::make(Auth::user()),
        ], 'User logged in successfully.');
    }

    public function profile()
    {
        $user = Auth::user();
        return $this->sendAPIResponse(UserProfileResource::make($user), 'Profile fetched successfully.');
    }

    public function updateProfile(UserProfileUpdateRequest $request)
    {
        $user = Auth::user();
        $attributes = $request->validated();
        $user->update(array_intersect_key($attributes, array_flip(['name', 'email'])));
        $user->profile()->update(array_intersect_key($attributes, array_flip(['mobile', 'school', 'dob', 'standard_id'])));

        if ($request->hasFile('img')) {
            $uploadedFile = $this->uploadFile($request->file('img'), 'users/profile/img/');
            $user->profile->img = $uploadedFile['name'];
            $user->profile->save();
        }
        return $this->sendAPIResponse(UserProfileResource::make($user), 'Profile Updated successfully.');
    }

    public function updatePassword(PasswordUpdateRequest $request)
    {
        $user = Auth::user();
        $attributes = $request->validated();
        $user->password = bcrypt($attributes['password']);
        $user->save();
        return $this->sendAPIResponse(UserProfileResource::make($user), 'Password updated successfully.');
    }

    private function validateCode($regCode)
    {
        $code = Code::where('code', $regCode)
            ->first();

        if (!$code) return false;
        return $code;
    }
}
