<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Content;
use App\Models\Subject;
use App\Models\ContentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BannerResource;
use App\Http\Resources\SubjectsResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\VideosResource;

class AuthController extends Controller
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        request()->validate([
            'type' => 'required',
        ]);

        $userType = request()->input('type');

        if ($userType === 'teacher') {
            $attributes = request()->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
                'standard_id' => 'required',
                'mobile' => 'required',
                'school' => 'required',
                'img' => 'file|mimes:jpeg,png,jpg',
                'type' => 'required',
            ]);
        } else {
            $attributes = request()->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
                'dob' => 'required',
                'standard_id' => 'required',
                'mobile' => 'required',
                'school' => 'required',
                'img' => 'file|mimes:jpeg,png,jpg',
                'type' => 'required',
            ]);
        }

        $existingUser = User::where('email', $attributes['email'])->first();

        if ($existingUser) {
            return $this->sendAPIError('Email already exists.', ['error' => 'Email already exists.']);
        }

        $newUser = User::create($attributes);

        if ($userType === 'teacher') {
            $newUser->profile()->create([
                'standard_id' => $attributes['standard_id'],
                'mobile' => $attributes['mobile'],
                'school' => $attributes['school'],
            ]);
        } else {
            $newUser->profile()->create([
                'standard_id' => $attributes['standard_id'],
                'dob' => $attributes['dob'],
                'mobile' => $attributes['mobile'],
                'school' => $attributes['school'],
            ]);
        }
        if ($request->hasFile('img')) {
            $uploadedFile = $this->uploadFile($request->file('img'), 'users/profile/img/');
            $newUser->profile->img = $uploadedFile['name'];
            $newUser->profile->save();
        }

        // Assign role to the user
        $newUser->assignRole($userType);

        $credentials = $request->only('email', 'password');
        Auth::once($credentials);

        $videoContentType = ContentType::whereName('Video')->first();
        $videos = $videoContentType->classContents()->take(5)->get();

        return $this->sendAPIResponse([
            'user' => UserResource::make($newUser),
            'banners' => BannerResource::make(null),
            'videos' => VideosResource::collection($videos),
            'subjects' => SubjectsResource::collection(Subject::all()),
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
            $videoContentType = ContentType::whereName('Video')->first();
            $videos = $videoContentType->classContents()->take(5)->get();

            return $this->sendAPIResponse([
                'user' => UserResource::make($user),
                'banners' => BannerResource::make(null),
                'videos' => VideosResource::collection($videos),
                'subjects' => SubjectsResource::collection(Subject::all()),
            ], 'User logged in successfully.');
        } else {
            return $this->sendAPIError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
}
