<?php

use App\Http\Controllers\Api\Auth\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', Register::class);
});
Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});
