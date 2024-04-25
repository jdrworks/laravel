<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::get('test', function() {
    $job = \App\Models\Job::first();
    \App\Jobs\TranslateJob::dispatch($job);

    return 'Done';
});

Route::view('/', 'home');
Route::view('/contact', 'contact');

Route::controller(JobController::class)->group(function() {
    Route::get('/jobs', 'index');

    Route::get('/jobs/create', 'create')
        ->middleware('auth');

    Route::post('/jobs', 'store')
        ->middleware('auth');

    Route::get('/jobs/{job}', 'show');

    Route::get('/jobs/{job}/edit', 'edit')
        ->middleware('auth')
        ->can('edit', 'job');

    Route::patch('/jobs/{job}', 'update')
        ->middleware('auth')
        ->can('edit', 'job');

    Route::delete('/jobs/{job}', 'destroy')
        ->middleware('auth')
        ->can('edit', 'job');
});

// Auth
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);
