<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EntryController;
use App\Http\Controllers\Api\QuoteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Itt definiáljuk az API végpontokat. Ezek a route-ok automatikusan
| /api prefix-et kapnak és stateless-ek (session nélkül működnek).
|
*/

// Publikus route-ok (nincs autentikáció)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Quote-ok (publikus, autentikáció nélkül is elérhető)
Route::get('/quotes', [QuoteController::class, 'index']);
Route::get('/quotes/random', [QuoteController::class, 'random']);

// Védett route-ok (auth:sanctum middleware szükséges)
Route::middleware('auth:sanctum')->group(function () {
    // Auth endpoint-ok
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // Entry CRUD műveletek
    Route::apiResource('entries', EntryController::class);
});
