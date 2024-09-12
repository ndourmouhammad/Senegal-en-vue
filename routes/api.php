<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authentification
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', [AuthController::class, 'refreshToken']);
Route::get('/me', [AuthController::class, 'userConnecte']);
Route::post('/update', [AuthController::class, 'update'])->middleware('auth');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');