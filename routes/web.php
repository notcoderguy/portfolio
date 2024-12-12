<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TranslateController;
use App\Http\Controllers\LocaleController;

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

Route::prefix('translation')->group(function () {
    Route::get('{model_type}/{model_id}/{locale}',  [TranslateController::class, 'getTranslation']);
    Route::get('{locale}/{key}',  [TranslateController::class, 'getTranslationByKey']);
    Route::post('{model_type}/{model_id}/{locale}/{key}',  [TranslateController::class, 'setTranslation']);
    Route::delete('{model_type}/{model_id}/{locale}/{key}',  [TranslateController::class, 'deleteTranslation']);
});

Route::group(['prefix' => '{locale?}', 'middleware' => 'setLocale'], function () {
    Route::view('/', 'welcome');
});

Route::get('/locale/{locale}', [LocaleController::class, 'switchLocale'])->name('switchLocale');
