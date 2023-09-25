<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function signUpUser(Request $request)
    {
        $fields = $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|email',
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'phonenumber' => 'required',
        ]);

        $user_exists = User::where('email', $fields['email'])->exists();

        if ($user_exists) {
            return response()->json(['message' => 'email is already in use!'], 400);
        }

        $user = User::create([
            'fname' => $fields['fname'],
            'lname' => $fields['lname'],
            'email' => $fields['email'],
            'phonenumber' => $fields['phonenumber'],
            'password' => bcrypt($fields['password']),
            'role_id' => 1
        ]);

        $userResource = new UserResource($user);
        $token = $user->createToken("mytoken")->plainTextToken;

        return response()->json([
            'user' => $userResource,
            'token' => $token
        ], 201);
    }

    public function signInUser(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Invalid credentials!!'
            ], 401);
        }

        $token = $user->createToken("mytoken")->plainTextToken;

        $userResource = new UserResource($user);

        $response = [
            'user' => $userResource,
            'token' => $token
        ];

        return response($response, 201);
    }
}
