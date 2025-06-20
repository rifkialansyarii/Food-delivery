<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
     public function register(RegisterRequest $request)
    {
        $payload = $request->validated();

        if (User::where('email', $payload['email'])->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email already exists',
            ], 422);
        }

        $users = User::create($payload);

        $users->password = Hash::make($payload['password']);

        $users->save();


        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $payload = $request->validated();

        $user = User::where('email', $payload['email'])->first();
        
        if (!$user ) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials',
            ], 401);
        }

        if (!Hash::check($payload['password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials',
            ], 401);
        }

        

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'token' => $token,
        ], 200);
    }
}
