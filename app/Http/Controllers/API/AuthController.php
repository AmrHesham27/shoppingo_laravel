<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(Request $request) {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required', 'string', 'confirmed', Password::defaults()],
            ]);
    
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);
    
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json(
                [
                    'status_code' => true,
                    'message' => "User was registered successfuly",
                    'data' => $token,
                ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'status_code' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
        
    }

    public function login(Request $request) {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()
                ->json([
                    'status_code' => false,
                    'message' => "Wrong Email or Password",
                ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json([
                'status_code' => true,
                'message' => 'Logged in successfully',
                'data' => [
                    'token' => $token,
                    'user' => $user
                ], 
            ]);
    }
}
