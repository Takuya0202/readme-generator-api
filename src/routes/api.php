<?php

use App\Http\Controllers\Api\Auth\Login;
use App\Http\Controllers\Api\Auth\Logout;
use App\Http\Controllers\Api\Auth\Register;
use App\Http\Controllers\Api\Project\Create;
use App\Http\Controllers\Api\Project\Index;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', Register::class);
    Route::post('login', Login::class);
    Route::post('logout', Logout::class)->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->prefix('projects')->group(function () {
    Route::get('/', Index::class);
    Route::post('/', Create::class);
});
