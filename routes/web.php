<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 🔐 Auth (Register & Login)
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClassController;

// 🛡️ Auth
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// 👤 User Management
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

// 📅 Jadwal Les Milik User Tertentu
Route::prefix('users/{user_id}')->group(function () {
    Route::get('/classes', [ClassController::class, 'indexByUser']);
    Route::post('/classes', [ClassController::class, 'store']);
});

// 📚 Kelas Umum
Route::prefix('classes')->group(function () {
    Route::get('/', [ClassController::class, 'index']);
    Route::get('/{id}', [ClassController::class, 'show']);
    Route::put('/{id}', [ClassController::class, 'update']);
    Route::delete('/{id}', [ClassController::class, 'destroy']);
});