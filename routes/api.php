<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DayEntryController;
use App\Http\Controllers\Api\MotivationalQuoteController;

/*
|--------------------------------------------------------------------------
| API Routes - Authentication
|--------------------------------------------------------------------------
*/

// Nyilvános útvonalak (nem kell bejelentkezés)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Védett útvonalak (kell Bearer token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});

/*
|--------------------------------------------------------------------------
| API Routes - Day Entries
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/day-entries', [DayEntryController::class, 'index']);
    Route::post('/day-entries', [DayEntryController::class, 'store']);
    Route::get('/day-entries/{dayEntry}', [DayEntryController::class, 'show']);
    Route::put('/day-entries/{dayEntry}', [DayEntryController::class, 'update']);
    Route::delete('/day-entries/{dayEntry}', [DayEntryController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| API Routes - Motivational Quotes
|--------------------------------------------------------------------------
*/

// NYILVÁNOS! Auth middleware NÉLKÜL!
Route::get('/quotes', [MotivationalQuoteController::class, 'index']);
Route::get('/quotes/random', [MotivationalQuoteController::class, 'random']);
