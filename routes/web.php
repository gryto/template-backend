<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// $router->get('/', function () use ($router) {
//     return response()->json(['Backend' => 'Running'], 200);
// });

Route::get('/', function () {
    return response()->json(['message' => 'Laravel API Running']);
});

// $router->group(['prefix' => 'api/v1/'], function () use ($router) {

//     $router->group(['prefix' => 'users/'], function () use ($router) {

//         $router->post('register', 'UserController@register'); // Tambah user


//     });
// });
