<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Boesl Admin Routes
    Route::middleware(['role:boesl-admin|super-admin'])
        ->prefix('boesl')
        ->name('boesl.')
        ->group(function () {
            Route::get('/applicants', [\App\Http\Controllers\BoeslApplicantController::class, 'index'])->name('applicants.index');
            Route::get('/applicants/create', [\App\Http\Controllers\BoeslApplicantController::class, 'create'])->name('applicants.create');
            Route::post('/applicants', [\App\Http\Controllers\BoeslApplicantController::class, 'store'])->name('applicants.store');
            Route::post('/applicants/import', [\App\Http\Controllers\BoeslApplicantController::class, 'import'])->name('applicants.import');
        });

    // BHC Admin Routes
    Route::middleware(['role:bhc-admin|super-admin'])
        ->prefix('bhc')
        ->name('bhc.')
        ->group(function () {
            Route::get('/applicants', [\App\Http\Controllers\BhcApplicantController::class, 'index'])->name('applicants.index');
            Route::get('/applicants/{applicant}/edit', [\App\Http\Controllers\BhcApplicantController::class, 'edit'])->name('applicants.edit');
            Route::put('/applicants/{applicant}', [\App\Http\Controllers\BhcApplicantController::class, 'update'])->name('applicants.update');
            Route::post('/applicants/{applicant}/registered', [\App\Http\Controllers\BhcApplicantController::class, 'markRegistered'])->name('applicants.markRegistered');
            Route::post('/applicants/{applicant}/tracking', [\App\Http\Controllers\BhcApplicantController::class, 'updateTracking'])->name('applicants.updateTracking');
        });
});

require __DIR__ . '/auth.php';