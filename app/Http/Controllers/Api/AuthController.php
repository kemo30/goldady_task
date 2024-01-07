<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\loginRequest;
use App\Http\Requests\registerRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            $token = $user->createToken('authToken')->plainTextToken;

           
        } return response()->json(['token' => $token, 'user' => new UserResource($user)]);

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function register(registerRequest $request)
    {
       
     
        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Optionally, you may generate a token here for immediate login.

        return response()->json(['message' => 'Registration successful'], 201);
    }
}
