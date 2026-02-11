<?php

use App\Http\Controllers\Api\Auth\Login;
use App\Http\Controllers\Api\Auth\Logout;
use App\Http\Controllers\Api\Auth\Register;
use App\Http\Controllers\Api\Project\Index;
use Gemini\Enums\ModelVariation;
use Gemini\GeminiHelper;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', Register::class);
    Route::post('login', Login::class);
    Route::post('logout', Logout::class)->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->prefix('projects')->group(function () {
    Route::get('/', Index::class);
});
Route::get('gemini/test', function () {
    try {
        $result = Gemini::generativeModel(model: 'models/gemini-2.5-flash')
            ->generateContent('こんにちは、世界！');

        return response()->json([
            'success' => true,
            'model' => 'gemini-2.5-flash',
            'text' => $result->text(),
            'tokens' => [
                'input' => $result->usageMetadata->promptTokenCount ?? 0,
                'output' => $result->usageMetadata->candidatesTokenCount ?? 0,
                'total' => $result->usageMetadata->totalTokenCount ?? 0,
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 429);
    }
});
