<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthApiController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'token' => $user->createToken('mobile-token')->plainTextToken,
            'user' => $user,
        ]);
    }

    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     if (!auth()->attempt($credentials)) {
    //         return response()->json(['message' => 'Thông tin không đúng'], 401);
    //     }

    //     $user = auth()->user();
    //     return response()->json([
    //         'token' => $user->createToken('mobile-token')->plainTextToken,
    //         'user' => $user,
    //     ]);
    // }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Đăng xuất thành công']);
    }
}
