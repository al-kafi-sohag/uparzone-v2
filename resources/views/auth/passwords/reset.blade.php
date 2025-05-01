@extends('layouts.app')

@section('content')
    <div class="flex justify-center mb-6">
        <img src="{{ asset('frontend/img/logo.svg') }}" alt="Logo" class="h-16">
    </div>

    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('Reset Password') }}</h1>
        <p class="mt-2 text-gray-600">{{ __('Create a new password for your account') }}</p>
    </div>

    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="space-y-2">
            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
            <input id="email" name="email" type="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
                placeholder="{{ __('Enter your email') }}"
                class="w-full px-3 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" readonly>
            @error('email')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
            <input id="password" name="password" type="password" required autocomplete="new-password"
                placeholder="{{ __('Enter new password') }}"
                class="w-full px-3 py-2 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            @error('password')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="password-confirm" class="block text-sm font-medium text-gray-700">{{ __('Confirm Password') }}</label>
            <input id="password-confirm" name="password_confirmation" type="password" required autocomplete="new-password"
                placeholder="{{ __('Confirm your new password') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full px-4 py-2 font-bold text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                {{ __('Reset Password') }}
            </button>
        </div>

        <div class="mt-4 text-sm text-center text-gray-600">
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
                {{ __('Back to login') }}
            </a>
        </div>
    </form>
@endsection
