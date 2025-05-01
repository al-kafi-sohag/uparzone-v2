@extends('layouts.app')

@section('content')
    <div class="flex justify-center mb-6">
        <img src="{{ asset('frontend/img/logo.svg') }}" alt="Logo" class="h-16">
    </div>

    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('Confirm Password') }}</h1>
        <p class="mt-2 text-gray-600">{{ __('Please confirm your password before continuing.') }}</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <div class="space-y-2">
            <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
            <input id="password" name="password" type="password" required autocomplete="current-password"
                placeholder="{{ __('Enter your password') }}"
                class="w-full px-3 py-2 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            @error('password')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full px-4 py-2 font-bold text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                {{ __('Confirm Password') }}
            </button>
        </div>

        @if (Route::has('password.request'))
            <div class="mt-4 text-sm text-center text-gray-600">
                <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline">
                    {{ __('Forgot Your Password?') }}
                </a>
            </div>
        @endif
    </form>
@endsection
