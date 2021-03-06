<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'phone' => 'required',
        ]);
        $token = random_int(0000, 9999);
        $user = 'user_'.$token;
        $user = User::firstOrCreate(
            ['phone' => $request->input('phone')],
            [
                'name' => $user,
                'balance' => 0,
            ]
        );

        $token = $user->createToken($request->input('phone'))->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function user(){
        return response()->json(Auth::user());
    }

    public function updateAddress(Request $request){
        $user = User::find(Auth::id());
        $user->update($request->all());
        return response()->json($user);
    }
    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'User logout successfully',
        ]);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:8',
        ]);

        $user = User::where('email', $request->input('email'))->first();
        if (!$user || !Hash::check($request->input('password'), $user->password)){
            return response()->json([
                'message' => 'The provided credentials are incorrect',
            ], 401);
        }
        $token = $user->createToken($user->name)->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 200);
    }
}
