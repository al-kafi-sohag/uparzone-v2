<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\User\GoogleController as UserGoogleController;
use App\Http\Controllers\User\OnboardingController as UserOnboardingController;

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
