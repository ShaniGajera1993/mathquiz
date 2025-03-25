<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MathQuestionController;

Route::get('/', function () {
    return view('import');
});

Route::post('/import', [MathQuestionController::class, 'import'])->name('import');
