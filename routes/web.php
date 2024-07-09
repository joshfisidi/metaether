<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AIController;

Route::get('/', [AIController::class, 'index'])->name('home');
Route::post('/analyze', [AIController::class, 'analyze'])->name('ai.analyze');
Route::get('/test-openai', [AIController::class, 'testOpenAI']);