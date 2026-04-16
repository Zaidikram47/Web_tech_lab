<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EventLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 2. Wrap both Profile and Employees in the Auth middleware
Route::middleware('auth')->group(function () {
    // These are the missing routes causing your error:
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Employee CRUD
    Route::resource('employees', EmployeeController::class);

    // Event Logs
    Route::get('/event-logs', [EventLogController::class, 'index'])->name('event-logs.index');
    Route::delete('/event-logs', [EventLogController::class, 'destroy'])->name('event-logs.destroy');
});

require __DIR__.'/auth.php';