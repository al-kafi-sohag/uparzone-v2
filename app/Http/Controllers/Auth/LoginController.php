<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'showLoginForm']);
        $this->middleware('auth')->only('logout');
    }

    /**
     * Show the application's login form.
     * If user is already authenticated, log them out first.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        // If user is already authenticated, log them out
        if (Auth::check()) {
            Auth::logout();

            // Clear session data
            request()->session()->invalidate();
            request()->session()->regenerateToken();
        }

        return view('auth.login');
    }
}
