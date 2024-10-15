<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationSeenController;
use App\Http\Controllers\RealtorListingAcceptOfferController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\RealtorListingImageController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;

Route::get('/', [ListingController::class, 'index']);
Route::get('/show', [IndexController::class, 'show'])->name('show');

Route::resource('listing', ListingController::class)
    ->only(['index', 'show']);

Route::resource('listing.offer', ListingOfferController::class)
    ->only(['store'])->middleware('auth');

Route::resource('notification', NotificationController::class)
    ->only(['index'])->middleware('auth');

Route::put('notification/{notification}/seen', NotificationSeenController::class)
    ->middleware('auth')->name('notification.seen');

Route::resource('user-account', UserAccountController::class)
    ->only(['create', 'store']);

Route::get('login', [AuthController::class, 'create'])->name('login');

Route::post('login', [AuthController::class, 'store'])->name('login.store');

Route::delete('logout', [AuthController::class, 'destroy'])->name('logout');


Route::get('/email/verify', function () {
    return Inertia('Auth/VerifyEmail');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->route('listing.index')->with('success', 'Email verified successfully!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return redirect()->back()->with('success', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');



Route::prefix('realtor')
    ->name('realtor.')
    ->middleware('auth', 'verified')
    ->group(function () {
        Route::resource('listing', RealtorListingController::class)
            ->withTrashed();

        Route::put(
            'offer/{offer}/accept',
            RealtorListingAcceptOfferController::class
        )->middleware('auth')->name('offer.accept');

        Route::put('listing/{listing}/restore', [RealtorListingController::class, 'restore'])
            ->name('listing.restore')
            ->withTrashed();

        Route::resource('listing.image', RealtorListingImageController::class)->only(['create', 'store', 'destroy']);
    });
