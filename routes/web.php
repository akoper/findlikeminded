<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\GroupUserController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/groups/all', [GroupController::class, 'all'])->name('groups.all'); // temp dev route

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('groups', GroupController::class);
    Route::post('/groups/join', [GroupController::class, 'join'])->name('groups.join');
    Route::post('/groups/leave', [GroupController::class, 'leave'])->name('groups.leave');

    Route::resource('events', EventController::class);
    Route::post('/events/join', [EventController::class, 'join'])->name('events.join');
    Route::post('/events/leave', [EventController::class, 'leave'])->name('events.leave');
    Route::post('/groups/add-admin', [GroupUserController::class, 'addAdmin'])->name('groups.addAdmin');

    Route::get('/users/autocomplete', [UserController::class, 'autocomplete'])
        ->name('users.autocomplete');

});
// this search feature is on the welcome page so guests can search for an interest,
// find matching groups and join the application - this is why it's not behind auth middleware
Route::post('/groups/search', [GroupController::class, 'search'])->name('groups.search');

// also for search topics feature
Route::get('/locations/autocomplete', [LocationController::class, 'autocomplete'])
    ->name('locations.autocomplete');

require __DIR__.'/auth.php';
