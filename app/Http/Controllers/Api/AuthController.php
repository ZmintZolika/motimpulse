<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function register(Request $request)
{
    try {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:150|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Sikeres regisztráció',
            'user' => [
                'user_id' => $user->user_id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token,
        ], 201);
    } catch (ValidationException $e) {
        return response()->json([
            'message' => 'Validációs hiba',
            'errors' => $e->errors()
        ], 422);
    }
}



    public function login(Request $request)
    {
 
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

      
        $user = User::where('email', $request->email)->first();

   
        if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'A megadott adatok helytelenek.',
                    'errors' => [
                        'email' => ['A megadott email vagy jelszó érvénytelen.']
                    ]
                ], 422);
            }

     
        $token = $user->createToken('auth-token')->plainTextToken;


        return response()->json([
            'message' => 'Sikeres bejelentkezés',
            'user' => [
                'user_id' => $user->user_id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token,
        ], 200);
    }


    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sikeres kijelentkezés',
        ], 200);
    }


    public function user(Request $request)
    {
        return response()->json([
            'user' => [
                'user_id' => $request->user()->user_id,
                'name' => $request->user()->name,
                'email' => $request->user()->email,
                'email_verified_at' => $request->user()->email_verified_at,
                'created_at' => $request->user()->created_at,
            ],
        ], 200);
    }
}
