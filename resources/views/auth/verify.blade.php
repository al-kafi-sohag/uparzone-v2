@extends('layouts.app')

@section('content')
    <div class="flex justify-center mb-6">
        <img src="{{ asset('frontend/img/logo.svg') }}" alt="Logo" class="h-16">
    </div>

    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('Verify Your Email') }}</h1>
        <p class="mt-2 text-gray-600">{{ __('We need to verify your email address') }}</p>
    </div>

    @if (session('resent'))
        <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ __('A fresh verification link has been sent to your email address.') }}
        </div>
    @endif

    <div class="p-4 mb-6 text-sm text-gray-700 bg-gray-100 rounded-lg">
        <p class="mb-2">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
        <p>
            {{ __('If you did not receive the email') }},
            <form class="inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="text-blue-600 hover:underline">{{ __('click here to request another') }}</button>.
            </form>
        </p>
    </div>

    <div class="mt-6 text-center">
        <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">
            {{ __('Back to login') }}
        </a>
    </div>
@endsection
