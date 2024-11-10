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
        $attributes = request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        if (User::where('email', $attributes['email'])->exists()) {
            return $this->sendAPIError('Email already exists.', ['error' => 'Email already exists.']);
        }

        $user = User::create($attributes);
        $token = $user->createToken('MyApp')->plainTextToken;

        return $this->sendAPIResponse(['name' => $user->name, 'token' => $token], 'User registered successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $attributes = $request->only('email', 'password');

        if (Auth::once($attributes)) {
            $token = Auth::user()->createToken('MyApp')->plainTextToken;

            $user = Auth::user();
            $token = $user->createToken('MyApp')->plainTextToken;
            $videoContentType = ContentType::whereName('Video')->first();
            $videos = $videoContentType->contents()->take(5)->get();

            return $this->sendAPIResponse([
                'token' => $token,
                'name' => $user->name,
                'videos' => VideosResource::collection($videos),
                'banners' => BannerResource::make(null),
                'subjects' => SubjectsResource::collection(Subject::all()),
            ], 'User logged in successfully.');
        } else {
            return $this->sendAPIError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
}
