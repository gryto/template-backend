<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

Route::prefix('v1')->group(function () {

    Route::prefix('users')->group(function () {
        Route::post('register', [UserController::class, 'register']); // Menambahkan user baru
        Route::get('all', [UserController::class, 'indexAll']); // Mendapatkan semua users
        Route::get('{id}', [UserController::class, 'find']); // Mendapatkan data user by id
        Route::post('update/{id}', [UserController::class, 'update']); // Mengubah user
        Route::delete('delete/{id}', [UserController::class, 'destroy']); // Menghapus user
    });  

    Route::prefix('roles')->group(function () {
        Route::post('create', [RoleController::class, 'create']); // Menambahkan role baru
        Route::get('all', [RoleController::class, 'indexAll']); // Mendapatkan semua roles
        Route::get('{id}', [RoleController::class, 'find']); // Mendapatkan data role by id
        Route::post('update/{id}', [RoleController::class, 'update']); // Mengubah role
        Route::delete('delete/{id}', [RoleController::class, 'destroy']); // Menghapus role
    });

});


