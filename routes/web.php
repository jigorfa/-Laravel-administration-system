<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\AttendanceController;
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
    Route::get('experience/{experience}/edit', [ExperienceController::class, 'edit'])->name('experience.edit');
    Route::put('experience/{experience}', [ExperienceController::class, 'update'])->name('experience.update');
    Route::delete('experience/{experience}', [ExperienceController::class, 'destroy'])->name('experience.destroy');

    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('attendance/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
    Route::put('attendance/{attendance}', [AttendanceController::class, 'update'])->name('attendance.update');
    Route::delete('attendance/{attendance}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');

    Route::get('attest', [AttestController::class, 'index'])->name('attest.index');
    Route::get('attest/create', [AttestController::class, 'create'])->name('attest.create');
    Route::post('attest', [AttestController::class, 'store'])->name('attest.store');
    Route::get('attest/{attest}/edit', [AttestController::class, 'edit'])->name('attest.edit');
    Route::put('attest/{attest}', [AttestController::class, 'update'])->name('attest.update');
    Route::delete('attest/{attest}', [AttestController::class, 'destroy'])->name('attest.destroy');

    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');

    Route::get('/experience/pdf', [ExperienceController::class, 'pdf'])->name('experiencePdf.generate');
    Route::get('/attendance/pdf', [AttendanceController::class, 'pdf'])->name('attendancePdf.generate');
    Route::get('/attest/pdf', [AttestController::class, 'pdf'])->name('attestPdf.generate');
});

require __DIR__.'/auth.php';
