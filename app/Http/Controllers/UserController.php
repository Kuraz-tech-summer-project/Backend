<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function signUpUser(Request $request)
    {
        $fields = $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|email',
            'password' => 'required',
            'phonenumber' => 'required'
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
            'password' => bcrypt($fields['password'])
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

    public function updateUser(Request $request, string $id)
    {
        if (!$id) {
            return response([
                'message' => 'No ID was provided!!'
            ], 401);
        }

        try {
            $user = User::findOrfail($id);
            $user->update($request->all());
            return new UserResource($user);
        } catch (ModelNotFoundException $ex) {
            return response([
                'message' => 'User was not found!'
            ], 404);
        }
    }

    public function findById(string $id)
    {
        if (!$id) {
            return response([
                'message' => 'No ID was provided!'
            ], 404);
        }

        try {
            $user = User::findOrfail($id);
            return new UserResource($user);
        } catch (ModelNotFoundException $ex) {
            return response([
                'message' => 'User was not found!'
            ], 404);
        }
    }

    public function getUsers(Request $request)
    {
        return new UserCollection(User::paginate());
    }
}
