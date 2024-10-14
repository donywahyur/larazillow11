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
use Illuminate\Support\Facades\Route;

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


Route::get('login', [AuthController::class, 'create'])->name('login');
Route::post('login', [AuthController::class, 'store'])->name('login.store');
Route::delete('logout', [AuthController::class, 'destroy'])->name('logout');

Route::resource('user-account', UserAccountController::class)
    ->only(['create', 'store']);

Route::prefix('realtor')
    ->name('realtor.')
    ->middleware('auth')
    ->group(function () {
        Route::resource('listing', RealtorListingController::class)
            // ->only(['index', 'destroy', 'edit', 'update', 'create', 'store'])
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
