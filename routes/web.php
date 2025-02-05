<?php

use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoogleLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('events', EventController::class);
    Route::post('/events/join', [EventController::class, 'join'])->name('events.join');
    Route::post('/events/leave', [EventController::class, 'leave'])->name('events.leave');

    Route::get('/users/autocomplete', [UserController::class, 'autocomplete'])
        ->name('users.autocomplete');

    Route::get('/subscribeCreateGroup', [SubscribeController::class, 'subscribeCreateGroup'])->name('subscribeCreateGroup');
    Route::get('/subscribeJoinGroup', [SubscribeController::class, 'subscribeJoinGroup'])->name('subscribeJoinGroup');
    Route::get('/subscribe/successCreateGroup', [SubscribeController::class, 'successCreateGroup'])->name('successCreateGroup');
    Route::get('/subscribe/successJoinGroup', [SubscribeController::class, 'successJoinGroup'])->name('successJoinGroup');
    Route::get('/subscribe/cancel', [SubscribeController::class, 'cancel'])->name('cancel');

    // subscribe middleware is applied to Group create and join methods in GroupController
    Route::get('/groups/search', [GroupController::class, 'searchForm'])->name('groups.search-form');
    Route::resource('groups', GroupController::class);
    Route::post('/groups/leave', [GroupController::class, 'leave'])->name('groups.leave');
    Route::post('/groups/add-admin', [GroupController::class, 'addAdmin'])->name('groups.addAdmin');
    Route::post('/groups/join', [GroupController::class, 'join'])->name('groups.join');

    Route::get('/email-form', [EmailController::class, 'emailForm'])->name('email.form');
    Route::post('/send', [EmailController::class, 'send'])->name('email.send');
});

// on welcome page for visitors so they search for a topic of interest, find a group and sign up
Route::post('/groups/search', [GroupController::class, 'search'])->name('groups.search');

// also for search group feature
Route::get('/locations/autocomplete', [LocationController::class, 'autocomplete'])
    ->name('locations.autocomplete');

Route::get('/google/redirect', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('login/facebook', [FacebookController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);

// required by Facebook for login with Facebook
Route::get('/privacy-policy', function () { return view('privacy-policy'); })->name('privacy-policy');
Route::get('/data-deletion', function () { return view('data-deletion');} )->name('data-deletion');
Route::get('/contact-us', function () { return view('contact-us');} )->name('contact-us');

require __DIR__.'/auth.php';
