<?php

use App\Http\Controllers\Contact\ContactController;
use App\Http\Controllers\Home\ShowHomeController;
use App\Http\Controllers\Jobs\JobListingController;
use Illuminate\Support\Facades\Route;

Route::get('/', ShowHomeController::class)->name('home');

// Public Jobs routes (Solves 404 at browse all jobs)
Route::get('/jobs', [JobListingController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{id}/jd', [JobListingController::class, 'downloadJd'])->name('jobs.jd');
Route::get('/jobs/{id}', [JobListingController::class, 'show'])->name('jobs.show');

// Public Contact routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/contacts', [ContactController::class, 'index'])->name('contacts');
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

