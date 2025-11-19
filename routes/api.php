<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EntryController;
use App\Http\Controllers\Api\QuoteController;

// ============================================
// Public Routes
// ============================================

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// User endpoint
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ============================================
// Protected Routes (auth:sanctum)
// ============================================

Route::middleware('auth:sanctum')->group(function () {
    
    // Quote API (Read-Only)
    Route::get('/quotes', [QuoteController::class, 'index']);
    Route::get('/quotes/random', [QuoteController::class, 'random']);
    
    // Entry API (Full CRUD)
    Route::get('/entries', [EntryController::class, 'index']);
    Route::post('/entries', [EntryController::class, 'store']);
    Route::get('/entries/{id}', [EntryController::class, 'show']);
    Route::put('/entries/{id}', [EntryController::class, 'update']);
    Route::patch('/entries/{id}', [EntryController::class, 'update']);
    Route::delete('/entries/{id}', [EntryController::class, 'destroy']);
});
