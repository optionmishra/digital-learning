<?php

namespace App\Http\Controllers\API;

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

        $existingUser = User::where('email', $attributes['email'])->first();

        if ($existingUser) {
            return $this->sendAPIError('Email already exists.', ['error' => 'Email already exists.']);
        }

        $newUser = User::create($attributes);

        $newUser->profile()->create([
            'standard_id' => $attributes['standard_id'],
            'mobile' => $attributes['mobile'],
            'school' => $attributes['school'],
            'dob' => $attributes['dob'] ?? null,
        ]);

        $newUser->assignBooks(explode(',', $attributes['books']));

        if ($request->hasFile('img')) {
            $uploadedFile = $this->uploadFile($request->file('img'), 'users/profile/img/');
            $newUser->profile->img = $uploadedFile['name'];
            $newUser->profile->save();
        }

        // Assign role to the user
        $newUser->assignRole($attributes['type']);

        $credentials = $request->only('email', 'password');
        Auth::once($credentials);

        return $this->sendAPIResponse([
            AppLoginResponseResource::make($newUser),
        ], 'User registered successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::once($credentials)) {
            $user = Auth::user();

            return $this->sendAPIResponse([
                AppLoginResponseResource::make($user),
            ], 'User logged in successfully.');
        } else {
            return $this->sendAPIError('Unauthorised.', ['error' => 'Unauthorised']);
        }
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
}
