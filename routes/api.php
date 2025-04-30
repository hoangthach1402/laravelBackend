<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VocabularyController;
use App\Http\Controllers\Api\HabitController; // Thêm import
use App\Http\Controllers\Api\AchievementController; // Thêm import
use Illuminate\Http\Request; // Thêm import nếu chưa có
use Illuminate\Support\Facades\Route;

// Public routes
Route::middleware('api')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/welcome', [AuthController::class, 'welcome']);

    // Authenticated routes
    Route::middleware('auth:sanctum')->group(function () {
        // User routes (Existing)
        Route::get('/user', [AuthController::class, 'getCurrentUser']); // Giữ lại route user hiện tại
        Route::get('/users', [AuthController::class, 'getAllUsers']);
        Route::get('/users/search', [AuthController::class, 'searchUserByEmail']);
        Route::get('/users/{id}', [AuthController::class, 'getUserById']);

        // Vocabulary routes (Existing)
        Route::apiResource('vocabularies', VocabularyController::class);

        // --- Habit Tracking Routes (Mới) ---
        // Habit Routes
        Route::apiResource('habits', HabitController::class);

        // Habit Progress Routes
        Route::get('/habits/{habit}/progress', [HabitController::class, 'getProgress']);
        Route::post('/habits/{habit}/progress', [HabitController::class, 'storeProgress']);
        Route::delete('/habits/{habit}/progress/{date}', [HabitController::class, 'destroyProgress']);

        // Achievement Routes
        Route::get('/achievements', [AchievementController::class, 'index']);
        // --- Kết thúc Habit Tracking Routes ---

        // Logout route (Ví dụ, nếu bạn có)
        // Route::post('/logout', [AuthController::class, 'logout']);
    });
});