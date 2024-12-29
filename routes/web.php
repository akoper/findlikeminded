<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GroupController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [GroupController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/{group}', [GroupController::class, 'show'])->name('groups.show');
//    Route::get('/groups', [GroupController::class, 'edit'])->name('groups.edit');
    Route::patch('/groups', [GroupController::class, 'update'])->name('groups.update');
    Route::delete('/groups', [GroupController::class, 'destroy'])->name('groups.destroy');
});

Route::post('/groups/search', [GroupController::class, 'search'])->name('groups.search');

require __DIR__.'/auth.php';
