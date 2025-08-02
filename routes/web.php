<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\EloquentSearchController;
use App\Http\Controllers\EvaluatorController;
use App\Models\Appointment;
use App\Models\PolicyRule;
use App\Models\User;
use App\Services\NestedEloquentFilter;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/search', [EloquentSearchController::class, 'index']);

Route::get('/eloquent-search', function (Request $request) {
    $results = null;
    $filters = $request->input('filters');
    if ($filters) {
        // Accept JSON string or array
        $filtersArr = is_array($filters) ? $filters : json_decode($filters, true);
        if (is_array($filtersArr)) {
            $query = Appointment::query();
            $results = NestedEloquentFilter::apply($query, $filtersArr)->get();
        }
    }
    return view('eloquent-search', [
        'results' => $results,
    ]);
})->name('eloquent-search');