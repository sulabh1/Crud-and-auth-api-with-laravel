<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //register

    public function register(Request $request)
    {
        $field = $request->validate([
            "name" => "required|string",
            "email" => "required|string|unique:users,email",
            "password" => "required|string|confirmed"
        ]);
        $user = User::create([
            "name" => $field["name"],
            "email" => $field["email"],
            "password" => bcrypt($field["password"])
        ]);
        $token = $user->createToken("myAppToken")->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }
    //login

    public function login(Request $request)
    {
        $field = $request->validate([
            "email" => "required|string",
            "password" => "required|string"
        ]);
        $user = User::where('email', $field["email"])->first();
        if (!$user || !Hash::check($field["password"], $user->password)) {
            return response([
                "message" => "Incorrect Email or password"
            ], 401);
        }
        $token = $user->createToken("myAppToken")->plainTextToken;
        $response = [
            "user" => $user,
            "token" => $token
        ];
        return response([
            'user' => $user,
            "token" => $token
        ]);
    }

    //logout
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            "message" => "logged out successfully",
        ];
    }
}
