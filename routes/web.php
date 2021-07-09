<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;



Route::get('/', [ListingController::class, 'index'])
    ->name('listings.index');

    
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/{listing}', [ListingController::class, 'show'])
    ->name('listings.show');
