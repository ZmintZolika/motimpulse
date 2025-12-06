<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

use Illuminate\Http\Request;


Route::get('/', function () {
    return view('/home');});

Route::view('/', 'home')->name('home');
Route::view('/login', 'login')->name('login');
Route::view('/register', 'register')->name('register');
Route::view('/naplo', 'day-entries')->name('day-entries');

//---------------------------------------------------------

Route::post('/set-token', function (Request $request) {
    session(['auth_token' => $request->token]);
    return response()->json(['message' => 'Token stored']);
});

Route::get('/teszt', function () {
    return 'Működik!';
});

Route::get('/teszt-token', function () {
    return session('auth_token') ?? 'Nincs token';
});

Route::get('/', function () {
    return view('home');
});

