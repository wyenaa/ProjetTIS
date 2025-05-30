<?php

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
});