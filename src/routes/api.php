<?php

use App\Http\Controllers\Api\Auth\Login;
use App\Http\Controllers\Api\Auth\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', Register::class);
    Route::post('login', Login::class);
});
