<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $token = $user->createToken("mytoken")->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
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

        $response = [
            'user' => $user,
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
        $user = User::find($id);

        if (is_null($user) || empty($user)) {
            return response([
                'message' => 'User was not found!'
            ], 404);
        }
        
        $user->update($request->all());
        return response($user, 200);
    }

    public function findById(string $id)
    {
        if (!$id) {
            return response([
                'message' => 'No ID was provided!'
            ], 404);
        }

        $user = User::find($id);
        
        if (is_null($user) || empty($user)) {
            return response([
                'message' => 'User was not found!'
            ], 404);
        }
        
        return response($user, 200);
    }

    public function getUsers(Request $request)
    {
        $perPage = $request->input('limit', 10); // Number of items per page, default to 10
        $page = $request->input('page', 1); // Current page number, default to 1

        $offset = ($page - 1) * $perPage;

        $results = DB::table('users')
            ->offset($offset)
            ->limit($perPage)
            ->get('*');

        $totalItems = DB::table('users')->count();
        $totalPages = ceil($totalItems / $perPage);

        $response = [
            'page' => $page,
            'limit' => $perPage,
            'total' => $totalPages,
            'data' => $results,
        ];

        return response($response, 200);
    }
}
