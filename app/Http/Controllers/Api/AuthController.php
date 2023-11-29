<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required'
        ]);
             $user = User::create([
                'name' => $validateData['name'],
                'email' => $validateData['email'],
                'password' => Hash::make($validateData['password']),
                'role'  => 'user'
             ]);

             $token = $user->createToken('auth_token')->plainTextToken;

             return response()->json([
                'acccess_token' => $token,
                // 'user'          => $user,
                'user'          => UserResource::make($user),
             ]);


        // $validateData['password'] = bcrypt($request->password);

        // $user = User::create($validateData);

        // $accessToken = $user->createToken('authToken')->accessToken;

        // return response(['user' => $user, 'access_token' => $accessToken]);
    }

    public function login()
    {

    }
}
