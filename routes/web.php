<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::prefix('admin')->group(function () {
    Route::view('/', 'dashboard')
        ->middleware(['auth', 'verified']);

    Route::view('dashboard', 'dashboard')
        ->middleware(['auth', 'verified'])
        ->name('dashboard');
    
    Route::view('profile', 'profile')
        ->middleware(['auth'])
        ->name('profile');
})->middleware(['auth', 'verified']);

Route::prefix('auth')->group(function () {
    require __DIR__.'/auth.php';
});
