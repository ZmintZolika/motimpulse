<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Regisztráció (új felhasználó létrehozása)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Validáció
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:150|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // User létrehozása
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Token generálás
        $token = $user->createToken('auth-token')->plainTextToken;

        // Válasz
        return response()->json([
            'message' => 'Sikeres regisztráció',
            'user' => [
                'user_id' => $user->user_id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token,
        ], 201);
    }

    /**
     * Bejelentkezés (token generálás)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validáció
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // User keresése email alapján
        $user = User::where('email', $request->email)->first();

        // Ellenőrzés: létezik-e a user és helyes-e a jelszó
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['A megadott adatok helytelenek.'],
            ]);
        }

        // Token generálás
        $token = $user->createToken('auth-token')->plainTextToken;

        // Válasz
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

    /**
     * Kijelentkezés (token törlése)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Aktuális token törlése
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sikeres kijelentkezés',
        ], 200);
    }

    /**
     * Bejelentkezett user adatai
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
