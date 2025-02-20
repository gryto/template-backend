<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ModuleController;

// Tidak perlu prefix 'v1', cukup gunakan langsung
Route::post('login', [AuthController::class, 'login']); // Login

Route::middleware('auth:sanctum')->group(function () { // Proteksi login

    //USER
    Route::prefix('users')->group(function () {
        Route::post('register', [UserController::class, 'register']); // Menambahkan user baru
        Route::get('all', [UserController::class, 'indexAll']); // Mendapatkan semua users
        Route::get('get-by-id/{id}', [UserController::class, 'find']); // Mendapatkan data user by id
        Route::post('update/{id}', [UserController::class, 'update']); // Mengubah user
        Route::delete('delete/{id}', [UserController::class, 'destroy']); // Menghapus user
    });

    //ROLE
    Route::prefix('roles')->group(function () {
        Route::post('create', [RoleController::class, 'create']); // Menambahkan role baru
        Route::get('all', [RoleController::class, 'indexAll']); // Mendapatkan semua roles
        Route::get('get-by-id/{id}', [RoleController::class, 'find']); // Mendapatkan data role by id
        Route::post('update/{id}', [RoleController::class, 'update']); // Mengubah role
        Route::delete('delete/{id}', [RoleController::class, 'destroy']); // Menghapus role
    });

    //MODULE
    Route::prefix('modules')->group(function () {
        Route::post('create', [ModuleController::class, 'create']); // Menambahkan Module baru
        Route::get('all', [ModuleController::class, 'indexAll']); // Mendapatkan semua Modules
        Route::get('get-by-id/{id}', [ModuleController::class, 'find']); // Mendapatkan data Module by id
        Route::post('update/{id}', [ModuleController::class, 'update']); // Mengubah Module
        Route::delete('delete/{id}', [ModuleController::class, 'destroy']); // Menghapus Module
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});