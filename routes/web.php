<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\GoogleController as UserGoogleController;
use App\Http\Controllers\User\OnboardingController as UserOnboardingController;


use App\Http\Controllers\Admin\AuthenticationController as AdminAuthenticationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::get('/', function () {
    return view('comming-soon');
});

Auth::routes();
Route::get('onboarding', [UserOnboardingController::class, 'index'])->name('onboarding');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::controller(UserGoogleController::class)->group(function(){
    Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});


//Admin Routes
Route::group([ 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::controller(AdminAuthenticationController::class)->group(function () {
        Route::get('login', 'login')->name('login');
        Route::post('login', 'loginCheck')->name('login');
        Route::post('logout', 'logout')->name('logout');
    });

    Route::group([ 'middleware' => 'auth:admin'], function () {
        Route::controller(AdminDashboardController::class)->group(function () {
            Route::get('dashboard', 'index')->name('dashboard');
        });
    });
});
