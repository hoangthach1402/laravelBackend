<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VocabularyController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VocabularyController as ApiVocabularyController;
use Illuminate\Support\Facades\Route;

// Web routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Web vocabulary routes
    Route::resource('vocabularies', VocabularyController::class);
});



require __DIR__.'/auth.php';