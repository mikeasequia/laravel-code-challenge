<?php

use App\Http\Controllers\AppointmentController;
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

Route::get('/', [EvaluatorController::class, 'index']);

Route::post('/evaluator/submit', 
[EvaluatorController::class, 'submitForm'])->name('evaluator.submit');

Route::get('/appointments', [AppointmentController::class, 'index']);

Route::get('/appointments/{id}', [AppointmentController::class, 'show']);

Route::post('/appointments/{appointment}/submit', [AppointmentController::class, 'submit'])
    ->name('appointments.submit');

Route::post('/appointments/{appointment}/approve', [AppointmentController::class, 'approve'])
    ->name('appointments.approve');

Route::post('/appointments/{appointment}/reject', [AppointmentController::class, 'reject'])
    ->name('appointments.reject');