<?php

use App\Http\Controllers\BhcApplicantController;
use App\Http\Controllers\BoeslApplicantController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware([\App\Http\Middleware\CheckRole::class . ':boesl-admin|super-admin'])
        ->prefix('boesl')
        ->name('boesl.')
        ->group(function () {
            Route::get('/applicants', [BoeslApplicantController::class, 'index'])->name('applicants.index');
            Route::get('/applicants/create', [BoeslApplicantController::class, 'create'])->name('applicants.create');
            Route::post('/applicants', [BoeslApplicantController::class, 'store'])->name('applicants.store');
            Route::post('/applicants/import', [BoeslApplicantController::class, 'import'])->name('applicants.import');
        });

    Route::middleware([\App\Http\Middleware\CheckRole::class . ':bhc-admin|super-admin'])
        ->prefix('bhc')
        ->name('bhc.')
        ->group(function () {
            Route::get('/applicants', [BhcApplicantController::class, 'index'])->name('applicants.index');
            Route::get('/applicants/{applicant}/edit', [BhcApplicantController::class, 'edit'])->name('applicants.edit');
            Route::put('/applicants/{applicant}', [BhcApplicantController::class, 'update'])->name('applicants.update');
            Route::post('/applicants/{applicant}/registered', [BhcApplicantController::class, 'markRegistered'])->name('applicants.markRegistered');
            Route::post('/applicants/{applicant}/tracking', [BhcApplicantController::class, 'updateTracking'])->name('applicants.updateTracking');
        });

    Route::middleware([\App\Http\Middleware\CheckRole::class . ':super-admin'])
        ->prefix('super-admin')
        ->name('super-admin.')
        ->group(function () {
            Route::resource('users', UserManagementController::class)->except('show');
        });
});

require __DIR__.'/auth.php';
