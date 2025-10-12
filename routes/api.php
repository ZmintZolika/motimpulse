<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DayEntryController;
use App\Http\Controllers\Api\MotivationalQuoteController;

// Nyilvános útvonalak (nem kell bejelentkezés)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Védett útvonalak (kell Bearer token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});


// Day Entries
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/day-entries', [DayEntryController::class, 'index']);
    Route::post('/day-entries', [DayEntryController::class, 'store']);
    Route::get('/day-entries/{dayEntry}', [DayEntryController::class, 'show']);
    Route::put('/day-entries/{dayEntry}', [DayEntryController::class, 'update']);
    Route::delete('/day-entries/{dayEntry}', [DayEntryController::class, 'destroy']);
});

// Motivational Quotes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/quotes', [MotivationalQuoteController::class, 'index']);
    Route::get('/quotes/random', [MotivationalQuoteController::class, 'random']);
});