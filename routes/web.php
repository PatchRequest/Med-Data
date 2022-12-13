<?php

use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//Route::get('/', [HomeController::class, 'index'])->name('home');
 // redirect / to /dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/aerzte', [App\Http\Controllers\DoctorController::class, 'index'])->name('doctors.index');
    Route::get('/dokumente', [DocumentsController::class, 'index'])->name('documents.index');
    Route::get('/dokumente/teilen/{doctor}', [DocumentsController::class, 'create'])->name('documents.create');
    Route::get('/dokumente/{document}', [DocumentsController::class, 'show'])->name('documents.show');
    Route::delete('/dokumente/{document}', [DocumentsController::class, 'destroy'])->name('documents.destroy');
    Route::post('/dokumente/upload/{doctor}', [DocumentsController::class, 'store'])->name('documents.store');
});



