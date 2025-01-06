<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    EmployeeController,
    EventController,
    DelayController,
    OccurrenceController,
    AttestController,
    EpiController,
};

Route::get('/', fn () => view('auth/login'));

Route::middleware(['auth', 'verified', 'verify'])->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [ProfileController::class, 'index'])->name('salary.calculate');
});

Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth', 'verify'])->group(function () {

    Route::prefix('employee')->name('employee.')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('index');
        Route::get('/{employee}/show', [EmployeeController::class, 'show'])->name('show');
        Route::get('/create', [EmployeeController::class, 'create'])->name('create');
        Route::post('/', [EmployeeController::class, 'store'])->name('store');
        Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('edit');
        Route::put('/{employee}', [EmployeeController::class, 'update'])->name('update');
        Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('destroy');
    });

    Route::get('/calendar', function () {
        return view('calendar.index');
    });
    
    Route::prefix('event')->name('event.')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::post('/', [EventController::class, 'store'])->name('ajax');
    });

    Route::prefix('delay')->name('binder.delay.')->group(function () {
        Route::get('/', [DelayController::class, 'index'])->name('index');
        Route::get('/{delay}/show', [DelayController::class, 'show'])->name('show');
        Route::get('/create', [DelayController::class, 'create'])->name('create');
        Route::post('/', [DelayController::class, 'store'])->name('store');
        Route::get('/{delay}/edit', [DelayController::class, 'edit'])->name('edit');
        Route::get('/employee/{code}', [DelayController::class, 'getEmployeeByCode'])->name('getEmployeeByCode');
        Route::put('/{delay}', [DelayController::class, 'update'])->name('update');
        Route::delete('/detail/{id}', [DelayController::class, 'deleteDetail'])->name('deleteDetail');
        Route::delete('/{delay}', [DelayController::class, 'destroy'])->name('destroy');
    });    

    Route::prefix('occurrence')->name('binder.occurrence.')->group(function () {
        Route::get('/', [OccurrenceController::class, 'index'])->name('index');
        Route::get('/{occurrence}/show', [OccurrenceController::class, 'show'])->name('show');
        Route::get('/create', [OccurrenceController::class, 'create'])->name('create');
        Route::get('/search', [OccurrenceController::class, 'search'])->name('search');
        Route::post('/', [OccurrenceController::class, 'store'])->name('store');
        Route::get('/{occurrence}/edit', [OccurrenceController::class, 'edit'])->name('edit');
        Route::get('/employee/{code}', [OccurrenceController::class, 'getEmployeeByCode'])->name('getEmployeeByCode');
        Route::put('/{occurrence}', [OccurrenceController::class, 'update'])->name('update');
        Route::delete('/detail/{id}', [OccurrenceController::class, 'deleteDetail'])->name('deleteDetail');
        Route::delete('/{occurrence}', [OccurrenceController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('attest')->name('sst.attest.')->group(function () {
        Route::get('/', [AttestController::class, 'index'])->name('index');
        Route::get('/{attest}/show', [AttestController::class, 'show'])->name('show');
        Route::get('/create', [AttestController::class, 'create'])->name('create');
        Route::post('/', [AttestController::class, 'store'])->name('store');
        Route::get('/employee/{code}', [AttestController::class, 'getEmployeeByCode'])->name('getEmployeeByCode');
        Route::get('/{attest}/edit', [AttestController::class, 'edit'])->name('edit');
        Route::put('/{attest}', [AttestController::class, 'update'])->name('update');
        Route::delete('/detail/{id}', [AttestController::class, 'deleteDetail'])->name('deleteDetail');
        Route::delete('/{attest}', [AttestController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('epi')->name('sst.epi.')->group(function () {
        Route::get('/', [EpiController::class, 'index'])->name('index');
        Route::get('/{epi}/show', [EpiController::class, 'show'])->name('show');
        Route::get('/create', [EpiController::class, 'create'])->name('create');
        Route::post('/', [EpiController::class, 'store'])->name('store');
        Route::get('/employee/{code}', [EpiController::class, 'getEmployeeByCode'])->name('getEmployeeByCode');
        Route::get('/{epi}/edit', [EpiController::class, 'edit'])->name('edit');
        Route::put('/{epi}', [EpiController::class, 'update'])->name('update');
        Route::delete('/detail/{id}', [EpiController::class, 'deleteDetail'])->name('deleteDetail');
        Route::delete('/{epi}', [EpiController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('pdf')->name('pdf.')->group(function () {
        Route::get('/attest/{pdf}', [AttestController::class, 'pdf'])->name('attest');
        Route::get('/delay/{pdf}', [DelayController::class, 'pdf'])->name('delay');
        Route::get('/employee/{code}', [EmployeeController::class, 'pdf'])->name('employee');
        Route::get('/occurrence/{pdf}', [OccurrenceController::class, 'pdf'])->name('occurrence');
        Route::get('/epi/{pdf}', [EpiController::class, 'pdf'])->name('epi');
    });
});

require __DIR__ . '/auth.php';