<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ImportLogController;
use App\Http\Controllers\ImportedDataController;


Route::redirect('/', 'login');

Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'dashboard')
        ->middleware('verified')
        ->name('dashboard');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    Route::middleware('permission:user-management')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('permissions', PermissionController::class);
    });

    Route::middleware('permission:import-data')->group(function () {
        // 1) Upload / Import form
        Route::get('import',  [ImportController::class, 'showForm'])
            ->name('import.form');
        Route::post('import', [ImportController::class, 'handle'])
            ->name('import.handle');

        // 2) View raw imported records
        Route::get('data/{type}', [ImportedDataController::class, 'index'])
            ->name('imported.index')
            ->whereIn('type', array_keys(config('imports')));

        // 3) Import history & error logs
        Route::get('imports',             [ImportLogController::class, 'index'])
            ->name('imports.log');
        Route::get('imports/{import}/errors', [ImportLogController::class, 'errors'])
            ->name('imports.errors');
    });
});

Route::get('/adminlte-test', function () {
    return view('adminlte-test');
});

require __DIR__.'/auth.php';
