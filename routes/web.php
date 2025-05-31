<?php

<<<<<<< HEAD
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
=======
/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// 🔐 Auth (Register & Login)
$router->post('/register', 'UserController@register');
$router->post('/login', 'UserController@login');

// 👤 User Management
$router->get('/users', 'UserController@index');            // List semua user
$router->get('/users/{id}', 'UserController@show');        // Detail user
$router->put('/users/{id}', 'UserController@update');      // Update user
$router->delete('/users/{id}', 'UserController@destroy');  // Hapus user

// 📅 Jadwal Les Milik User Tertentu (per user_id)
$router->group(['prefix' => 'users/{user_id}'], function () use ($router) {
    $router->get('/classes', 'ClassController@indexByUser');   // Ambil semua kelas milik user tertentu
    $router->post('/classes', 'ClassController@store');        // Tambah kelas untuk user tersebut
});

// 📚 Kelas Umum (admin access or for debugging/testing)
$router->group(['prefix' => 'classes'], function () use ($router) {
    $router->get('/', 'ClassController@index');         // List semua kelas (semua user)
    $router->get('/{id}', 'ClassController@show');      // Detail kelas
    $router->put('/{id}', 'ClassController@update');    // Update kelas
    $router->delete('/{id}', 'ClassController@destroy');// Hapus kelas
>>>>>>> ab45104df30133a776c37302ffe0fec01274cd77
});