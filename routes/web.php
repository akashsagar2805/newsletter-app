<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsletterController;

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
    Route::get('/newsletters', [NewsletterController::class, 'index'])->name('newsletters.index'); // List newsletters
    Route::get('/newsletters/create', [NewsletterController::class, 'create'])->name('newsletters.create'); // Create newsletter form
    Route::post('/newsletters', [NewsletterController::class, 'store'])->name('newsletters.store'); // Store newsletter
    Route::post('/newsletters/{newsletter}/start', [NewsletterController::class, 'start'])->name('newsletters.start'); // Start sending newsletter
});

require __DIR__.'/auth.php';
