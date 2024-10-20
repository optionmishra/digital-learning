<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

            return $this->sendAPIResponse([
                'token' => $token,
                'name' => Auth::user()->name
            ], 'User login successfully.');
        } else {
            return $this->sendAPIError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
}
