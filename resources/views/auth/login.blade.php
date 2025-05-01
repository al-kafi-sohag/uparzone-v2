@extends('layouts.app')

@section('content')
    <div class="flex justify-center mb-6">
        <img src="{{ asset('frontend/img/logo.svg') }}" alt="Logo" class="h-16">
    </div>

    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('Login') }}</h1>
        <p class="mt-2 text-gray-600">{{ __('Sign in to your account') }}</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div class="space-y-2">
            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                placeholder="{{ __('Enter your email') }}"
                class="w-full px-3 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            @error('email')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
            <input id="password" name="password" type="password" required autocomplete="current-password"
                placeholder="{{ __('Enter your password') }}"
                class="w-full px-3 py-2 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            @error('password')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}
                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="remember" class="block ml-2 text-sm text-gray-700">{{ __('Remember Me') }}</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                    {{ __('Forgot Password?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full px-4 py-2 font-bold text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                {{ __('Login') }}
            </button>
        </div>

        <!-- Google Login Button -->
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 text-gray-500 bg-white">{{ __('Or continue with') }}</span>
            </div>
        </div>

        <div>
            <a href="{{ route('auth.google') }}" type="button"
                class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                    <g transform="matrix(1, 0, 0, 1, 27.009001, -39.238998)">
                        <path fill="#4285F4"
                            d="M -3.264 51.509 C -3.264 50.719 -3.334 49.969 -3.454 49.239 L -14.754 49.239 L -14.754 53.749 L -8.284 53.749 C -8.574 55.229 -9.424 56.479 -10.684 57.329 L -10.684 60.329 L -6.824 60.329 C -4.564 58.239 -3.264 55.159 -3.264 51.509 Z" />
                        <path fill="#34A853"
                            d="M -14.754 63.239 C -11.514 63.239 -8.804 62.159 -6.824 60.329 L -10.684 57.329 C -11.764 58.049 -13.134 58.489 -14.754 58.489 C -17.884 58.489 -20.534 56.379 -21.484 53.529 L -25.464 53.529 L -25.464 56.619 C -23.494 60.539 -19.444 63.239 -14.754 63.239 Z" />
                        <path fill="#FBBC05"
                            d="M -21.484 53.529 C -21.734 52.809 -21.864 52.039 -21.864 51.239 C -21.864 50.439 -21.724 49.669 -21.484 48.949 L -21.484 45.859 L -25.464 45.859 C -26.284 47.479 -26.754 49.299 -26.754 51.239 C -26.754 53.179 -26.284 54.999 -25.464 56.619 L -21.484 53.529 Z" />
                        <path fill="#EA4335"
                            d="M -14.754 43.989 C -12.984 43.989 -11.404 44.599 -10.154 45.789 L -6.734 42.369 C -8.804 40.429 -11.514 39.239 -14.754 39.239 C -19.444 39.239 -23.494 41.939 -25.464 45.859 L -21.484 48.949 C -20.534 46.099 -17.884 43.989 -14.754 43.989 Z" />
                    </g>
                </svg>
                {{ __('Sign in with Google') }}
            </a>
        </div>

        <div class="mt-4 text-sm text-center text-gray-600">
            {{ __('Don\'t have an account?') }}
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">
                {{ __('Sign up') }}
            </a>
        </div>
    </form>
@endsection
