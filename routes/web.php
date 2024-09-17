<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\ClockController;
use App\Http\Controllers\AttestController;
use App\Http\Controllers\CalendarController;

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/dashboard', [ProfileController::class, 'index'])->middleware(['auth', 'verified', 'admin'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('experience', [ExperienceController::class, 'index'])->name('experience.index');
    Route::get('experience/create', [ExperienceController::class, 'create'])->name('experience.create');
    Route::post('experience', [ExperienceController::class, 'store'])->name('experience.store');
    Route::get('experience/{experience}', [ExperienceController::class, 'show'])->name('experience.show');
    Route::get('experience/{experience}/edit', [ExperienceController::class, 'edit'])->name('experience.edit');
    Route::put('experience/{experience}', [ExperienceController::class, 'update'])->name('experience.update');
    Route::delete('experience/{experience}', [ExperienceController::class, 'destroy'])->name('experience.destroy');

    Route::get('clock', [ClockController::class, 'index'])->name('clock.index');
    Route::get('clock/create', [ClockController::class, 'create'])->name('clock.create');
    Route::post('clock', [ClockController::class, 'store'])->name('clock.store');
    Route::get('clock/{clock}', [ClockController::class, 'show'])->name('clock.show');
    Route::get('clock/{clock}/edit', [ClockController::class, 'edit'])->name('clock.edit');
    Route::put('clock/{clock}', [ClockController::class, 'update'])->name('clock.update');
    Route::delete('clock/{clock}', [ClockController::class, 'destroy'])->name('clock.destroy');

    Route::get('attest', [AttestController::class, 'index'])->name('attest.index');
    Route::get('attest/create', [AttestController::class, 'create'])->name('attest.create');
    Route::post('attest', [AttestController::class, 'store'])->name('attest.store');
    Route::get('attest/{attest}', [AttestController::class, 'show'])->name('attest.show');
    Route::get('attest/{attest}/edit', [AttestController::class, 'edit'])->name('attest.edit');
    Route::put('attest/{attest}', [AttestController::class, 'update'])->name('attest.update');
    Route::delete('attest/{attest}', [AttestController::class, 'destroy'])->name('attest.destroy');

    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');

    Route::get('/pdf', [ExperienceController::class, 'pdf'])->name('pdf.generate');
});

require __DIR__.'/auth.php';
