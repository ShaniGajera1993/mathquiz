<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MathQuestionController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/mathquestions/import', [MathQuestionController::class, 'importMathQuestions']);
});

Route::middleware('auth:sanctum', 'role:user')->group(function () {
    Route::get('/mathquestions', [MathQuestionController::class, 'getMathQuestions']);
});
