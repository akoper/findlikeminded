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
    Route::post('/groups/add-admin', [GroupController::class, 'addAdmin'])->name('groups.addAdmin');

    Route::resource('events', EventController::class);
    Route::post('/events/join', [EventController::class, 'join'])->name('events.join');
    Route::post('/events/leave', [EventController::class, 'leave'])->name('events.leave');

    Route::get('/users/autocomplete', [UserController::class, 'autocomplete'])
        ->name('users.autocomplete');

});

// on welcome page for visitors so they search for a topic  interest, find a group and sign up
Route::post('/groups/search', [GroupController::class, 'search'])->name('groups.search');

// also for search group feature
Route::get('/locations/autocomplete', [LocationController::class, 'autocomplete'])
    ->name('locations.autocomplete');

Route::get('/google/redirect', [App\Http\Controllers\GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [App\Http\Controllers\GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('/privacy-policy', function () { return view('privacy-policy'); });
Route::get('/data-deletion', function () { return view('data-deletion');} );
require __DIR__.'/auth.php';
