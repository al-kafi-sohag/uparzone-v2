@extends('layouts.app')

@section('content')
    <div class="flex justify-center mb-6">
        <img src="{{ asset('frontend/img/logo.svg') }}" alt="Logo" class="h-16">
    </div>

    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('Reset Password') }}</h1>
        <p class="mt-2 text-gray-600">{{ __('Enter your email to receive a password reset link') }}</p>
    </div>

    @if (session('status'))
        <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
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

        <div class="pt-2">
            <button type="submit"
                class="w-full px-4 py-2 font-bold text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                {{ __('Send Password Reset Link') }}
            </button>
        </div>

        <div class="mt-4 text-sm text-center text-gray-600">
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
                {{ __('Back to login') }}
            </a>
        </div>
    </form>
@endsection
