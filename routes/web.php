<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard',[DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/penilaian-cs', [InputController::class, 'penilaiancs'])->name('input-penilaian-cs');
    Route::post('/penilaian-cs', [InputController::class, 'actioninputpenilaiancs']);
    Route::get('/penilaian-cs/create', [InputController::class, 'inputpenilaiancs']);
    Route::get('/penilaian-teller', [InputController::class, 'penilaianteller'])->name('input-penilaian-teller');
    Route::post('/penilaian-teller', [InputController::class, 'actioninputpenilaianteller'])->name('input-penilaian-teller');
    Route::get('/penilaian-teller/create', [InputController::class, 'inputpenilaianteller'])->name('input-penilaian-teller');
});

require __DIR__.'/auth.php';
