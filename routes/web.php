<?php
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return response()->json(['message' => 'Laravel API Running']);
});

// Route::get('/csrf-token', function () {
//     return response()->json(['csrf_token' => csrf_token()]);
// });

// Route::get('/session-test', function () {
//     session(['test' => 'works']);
//     return session('test');
// });



