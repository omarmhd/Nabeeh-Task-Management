<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return response()->json([
            "status"=>true,
            "data"=>[
                "user"=>$user,
                'token' => $user->createToken('API Token')->plainTextToken]

        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!auth()->attempt($credentials)) {
            return response()->json([
                "status"=>false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = auth()->user();
        return response()->json(['token' => $user->createToken('API Token Access')->plainTextToken]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            "status"=>true,
            'message' => 'Logged out'
        ]);
    }
}
