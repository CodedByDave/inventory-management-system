<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\AuthController;

/**
 * Public Routes (accessible without login)
 */
Route::get('/test', function(){
    return view('test');
});


require __DIR__ . '/auth.php';
