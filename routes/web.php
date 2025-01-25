<?php

use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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

    // wouldn't normally hard code product id and price id here, but its so simple, will do
    Route::get('/subscribe', function (Request $request) {

        // TODO: change for prod - move subscription product values to db table?
        if('local' == App::environment()) {
            $product = 'prod_Rdyo9nUDWFaX3h';
            $price = 'price_1Qkgr4Az8wYmHt8vp5njDBoF';
        } else {
            $product = 'prod_ReJ2OmMZtorOIm';
            $price = 'price_1Ql0RUAz8wYmHt8vDO91Eg6T';
        }

        return $request->user()
            ->newSubscription($product, $price)
            ->checkout([
                'success_url' => route('subscribe-success'),
                'cancel_url' => route('subscribe-cancel'),
            ]);
        // guessing Stripe webhook sends back to app db that user is now a subscriber but can't test with local url
        // ])->create($request->paymentMethodId);
    })->name('subscribe');

    Route::get('/subscribe/subscribe-success', function () {
        return view('subscribe.subscribe-success');
    })->name('subscribe-success');

    Route::get('/subscribe/subscribe-cancel', function () {
        return view('subscribe.subscribe-cancel');
    })->name('subscribe-cancel');

    // subscribe middleware is applied to group create and join methods in controller
    Route::resource('groups', GroupController::class);
    Route::post('/groups/leave', [GroupController::class, 'leave'])->name('groups.leave');
    Route::post('/groups/add-admin', [GroupController::class, 'addAdmin'])->name('groups.addAdmin');
    Route::post('/groups/join', [GroupController::class, 'join'])->name('groups.join');
});

//Route::post('/stripe/webhook', 'Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook')->name('cashier.webhook');

// on welcome page for visitors so they search for a topic  interest, find a group and sign up
Route::post('/groups/search', [GroupController::class, 'search'])->name('groups.search');

// also for search group feature
Route::get('/locations/autocomplete', [LocationController::class, 'autocomplete'])
    ->name('locations.autocomplete');

Route::get('/google/redirect', [App\Http\Controllers\GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [App\Http\Controllers\GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('login/facebook', [FacebookController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);

// required by Facebook for login with Facebook
Route::get('/privacy-policy', function () { return view('privacy-policy'); });
Route::get('/data-deletion', function () { return view('data-deletion');} );

require __DIR__.'/auth.php';
