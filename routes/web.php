<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\User\GoogleController as UserGoogleController;
use App\Http\Controllers\User\OnboardingController as UserOnboardingController;
use App\Http\Controllers\User\HomeController as UserHomeController;
use App\Http\Controllers\User\AuthenticationController as UserAuthenticationController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\User\TimeTrackingController as UserTimeTrackingController;
use App\Http\Controllers\User\PostController as UserPostController;
use App\Http\Controllers\User\ReactionsController as UserReactionsController;
use App\Http\Controllers\User\CommentController as UserCommentController;
use App\Http\Controllers\User\WalletController as UserWalletController;
use App\Http\Controllers\User\PaymentController as UserPaymentController;
use App\Http\Controllers\User\WithdrawController as UserWithdrawController;
use App\Http\Controllers\User\TransactionController as UserTransactionController;


use App\Http\Controllers\Admin\AuthenticationController as AdminAuthenticationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GenderController as AdminGenderController;
use App\Http\Controllers\Admin\MoodController as AdminMoodController;
use App\Http\Controllers\Admin\PostCategoryController as AdminPostCategoryController;
use App\Http\Controllers\Admin\ReligionController as AdminReligionController;

Route::get('/', function () {
    return redirect()->route('user.maintenance');
});

//User Before
Auth::routes();
Route::get('onboarding', [UserOnboardingController::class, 'index'])->name('user.onboarding');
Route::get('maintenance', [UserOnboardingController::class, 'maintenance'])->name('user.maintenance');
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

Route::group(['as' => 'user.', 'middleware' => ['auth:web']], function () {
    Route::post('logout', [UserAuthenticationController::class, 'logout'])->name('logout');

    Route::controller(UserHomeController::class)->group(function () {
        Route::get('home', 'home')->name('home')->middleware('user.profile.complete');
    });

    Route::controller(UserProfileController::class)->group(function () {
        Route::get('complete-profile', 'completeProfile')->name('cp');
        Route::post('complete-profile', 'storeProfileData')->name('cp.store');
        Route::post('set-language', 'setLanguage')->name('cp.language');
        Route::post('verify-reference-code', 'verifyReferenceCode')->name('cp.verify.reference');
        Route::get('profile', 'profile')->name('profile');
        Route::get('migrating', 'migrating')->name('migrating');
    });

    Route::post('heartbeat', [UserTimeTrackingController::class, 'heartbeat'])->name('heartbeat');

    Route::controller(UserPostController::class)->group(function () {
        Route::get('post/create', 'create')->name('post.create');
        Route::post('post/store', 'store')->name('post.store');
        Route::post('post/upload-media', 'uploadMedia')->name('post.upload.media');
        Route::delete('post/remove-media', 'removeMedia')->name('post.remove.media');
    });

    Route::controller(UserReactionsController::class)->group(function () {
        Route::post('post/reaction', 'store')->name('post.reaction');
    });

    Route::controller(UserCommentController::class)->group(function () {
        Route::post('post/comment', 'store')->name('post.comment');
        Route::post('post/comments', 'getComments')->name('post.comments');
    });

    Route::controller(UserWalletController::class)->group(function () {
        Route::get('wallet', 'index')->name('wallet');
    });

    Route::controller(UserPaymentController::class)->group(function () {
        Route::get('payment/init', 'init')->name('payment.init');
    });

    Route::controller(UserWithdrawController::class)->group(function () {
        Route::get('withdraws', 'index')->name('withdraws');
        Route::post('withdraw/store', 'store')->name('withdraw.store');
        Route::get('withdraw/list', 'list')->name('withdraw.list');
    });

    Route::controller(UserTransactionController::class)->group(function () {
        Route::get('transactions', 'index')->name('transactions');
    });
});

//SSLCommerz Routes
Route::controller(UserPaymentController::class)->group(function () {
    Route::post('payment/ssl/success', 'success')->name('payment.ssl.success')->withoutMiddleware(VerifyCsrfToken::class);
    Route::post('payment/ssl/fail', 'fail')->name('payment.ssl.fail')->withoutMiddleware(VerifyCsrfToken::class);
    Route::post('payment/ssl/cancel', 'cancel')->name('payment.ssl.cancel')->withoutMiddleware(VerifyCsrfToken::class);
    Route::post('payment/ssl/ipn', 'ipn')->name('payment.ssl.ipn')->withoutMiddleware(VerifyCsrfToken::class);
});
