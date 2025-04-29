<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VocabularyController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::middleware('api')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/welcome', [AuthController::class, 'welcome']);
    Route::middleware('auth:sanctum')->group(function () {
        // User routes
        Route::get('/user', [AuthController::class, 'getCurrentUser']);
        Route::get('/users', [AuthController::class, 'getAllUsers']);
        Route::get('/users/search', [AuthController::class, 'searchUserByEmail']);
        Route::get('/users/{id}', [AuthController::class, 'getUserById']);
        

        
        // Sửa lại route resource
        Route::apiResource('vocabularies', VocabularyController::class);
    });
});