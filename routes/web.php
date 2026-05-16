<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestReportController;
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

    Route::get('/testpage/{group}', [AdminController::class, 'testPage'])->name('admin.testpage');
    Route::get('/testpage-one/{group}', [AdminController::class, 'testPageOne'])->name('admin.testpage-one');
    Route::get('/testpage-four/{group}', [AdminController::class, 'testPageFour'])->name('admin.testpage-four');

    Route::get('/testpage-pause/{group}', [AdminController::class, 'testPagePause'])->name('admin.testpage-pause');

    Route::get('/test-report/{group}', [TestReportController::class, 'generate'])
        ->name('test.report');

});

require __DIR__.'/auth.php';
