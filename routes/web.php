<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\GoogleController as UserGoogleController;
use App\Http\Controllers\User\OnboardingController as UserOnboardingController;


use App\Http\Controllers\Admin\AuthenticationController as AdminAuthenticationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GenderController as AdminGenderController;
use App\Http\Controllers\Admin\MoodController as AdminMoodController;
use App\Http\Controllers\Admin\PostCategoryController as AdminPostCategoryController;
use App\Http\Controllers\Admin\ReligionController as AdminReligionController;

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
            Route::post('theme/update', 'themeUpdate')->name('theme.update');
        });

        Route::prefix('gender')->name('gender.')->group(function () {
            Route::controller(AdminGenderController::class)->group(function () {
                Route::get('list', 'list')->name('list');
                Route::get('create', 'create')->name('create');
                Route::post('store', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::put('update/{id}', 'update')->name('update');
                Route::delete('delete/{id}', 'delete')->name('delete');
            });
        });

        Route::prefix('mood')->name('mood.')->group(function () {
            Route::controller(AdminMoodController::class)->group(function () {
                Route::get('list', 'list')->name('list');
                Route::get('create', 'create')->name('create');
                Route::post('store', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::put('update/{id}', 'update')->name('update');
                Route::delete('delete/{id}', 'delete')->name('delete');
            });
        });

        Route::prefix('post-category')->name('post-category.')->group(function () {
            Route::controller(AdminPostCategoryController::class)->group(function () {
                Route::get('list', 'list')->name('list');
                Route::get('create', 'create')->name('create');
                Route::post('store', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::put('update/{id}', 'update')->name('update');
                Route::delete('delete/{id}', 'delete')->name('delete');
            });
        });

        Route::prefix('religion')->name('religion.')->group(function () {
            Route::controller(AdminReligionController::class)->group(function () {
                Route::get('list', 'list')->name('list');
                Route::get('create', 'create')->name('create');
                Route::post('store', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::put('update/{id}', 'update')->name('update');
                Route::delete('delete/{id}', 'delete')->name('delete');
            });
        });
    });
});
