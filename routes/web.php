<?php

use App\Http\Controllers\EvaluatorController;
use App\Models\PolicyRule;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/rules', function() {
    return PolicyRule::all();
});

Route::get('/users', function() {
    return User::all();
});

Route::get('/', 
[EvaluatorController::class, 'index']);

Route::post('/evaluator/submit', 
[EvaluatorController::class, 'submitForm'])->name('evaluator.submit');