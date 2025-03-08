<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UrlController;
use App\Http\Controllers\AnalyticsController;

Route::post('/shorten', [UrlController::class, 'shorten']);
Route::get('/{shortCode}', [UrlController::class, 'redirect']);
Route::get('/analytics/{shortCode}', [AnalyticsController::class, 'show']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
