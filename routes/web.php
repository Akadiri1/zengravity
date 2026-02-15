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

Route::middleware(['auth', 'verified'])->group(function () {
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

    // Subscription Routes
    Route::get('/pricing', [App\Http\Controllers\SubscriptionController::class, 'index'])->name('subscription.pricing');
    Route::get('/checkout/{plan}', [App\Http\Controllers\SubscriptionController::class, 'checkout'])->name('subscription.checkout');
    Route::get('/billing-portal', [App\Http\Controllers\SubscriptionController::class, 'portal'])->name('subscription.portal');
    Route::get('/subscription/sync', [App\Http\Controllers\SubscriptionController::class, 'sync'])->name('subscription.sync');

    // Exam Forge (Module 4)
    Route::prefix('exam')->name('exam.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\ExamController::class, 'dashboard'])->name('dashboard');
        Route::post('/upload', [\App\Http\Controllers\ExamController::class, 'uploadMaterial'])->name('upload');
    });

    // API Routes for Scraper
    Route::post('/api/exam/solve', [\App\Http\Controllers\ExamController::class, 'solve'])->name('api.solve');
    
    // Reverse Proxy Tunnel
    Route::any('/proxy', [\App\Http\Controllers\ProxyController::class, 'browse'])->name('proxy');
    
    // Proxy Fallback for "Leaked" Relative Assets (Moodle specific)
    Route::any('/theme/{path}', [\App\Http\Controllers\ProxyController::class, 'fallback'])->where('path', '.*');
    Route::any('/lib/{path}', [\App\Http\Controllers\ProxyController::class, 'fallback'])->where('path', '.*');
    Route::any('/pluginfile.php/{path}', [\App\Http\Controllers\ProxyController::class, 'fallback'])->where('path', '.*');
    Route::any('/extensions/{path}', [\App\Http\Controllers\ProxyController::class, 'fallback'])->where('path', '.*');
    // Admin Routes
    Route::middleware([\App\Http\Middleware\EnsureUserIsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [\App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
        Route::put('/users/{user}/note', [\App\Http\Controllers\AdminController::class, 'updateNote'])->name('users.note');
        Route::post('/changelog', [\App\Http\Controllers\AdminController::class, 'storeChangelog'])->name('changelog.store');
        Route::delete('/changelog/{changelog}', [\App\Http\Controllers\AdminController::class, 'deleteChangelog'])->name('changelog.delete');
    });

    // Public Updates
    Route::get('/updates', [\App\Http\Controllers\ChangelogController::class, 'index'])->name('updates');
});

require __DIR__.'/auth.php';
