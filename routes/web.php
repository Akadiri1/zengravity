<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScannerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/app', function () {
    $scans = auth()->user()->scans()->latest()->take(5)->get();
    return view('dashboard', compact('scans'));
})->middleware(['auth', 'verified'])->name('app');

Route::middleware('auth')->group(function () {
    // Collab Forge
    Route::post('/collab/profile', [\App\Http\Controllers\CollabController::class, 'storeProfile'])->name('collab.profile');
    Route::get('/collab/matches', [\App\Http\Controllers\CollabController::class, 'findMatches'])->name('collab.matches');
    
    // Hive Scout
    Route::get('/hive-scout', [\App\Http\Controllers\HiveController::class, 'index'])->name('hive.index');

    // Ghost Scanner
    Route::post('/scan/upload', [ScannerController::class, 'store'])->name('scan.upload');
    Route::get('/scan/{scan}', [ScannerController::class, 'show'])->name('scan.show');
    Route::resource('scans', \App\Http\Controllers\ScanController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
