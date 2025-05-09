<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ config('app.url') }}">
    <meta name="app-name" content="{{ config('app.name') }}">
    <meta name="locale" content="{{ app()->getLocale() }}">


    <title>
        @yield('title', 'UPARZONE') -
        {{ config('app.name', 'UPARZONE') }} -
        {{ __('A social earning network system') }}
    </title>

    <link rel="icon" type="image/x-icon" href="{{ asset('frontend/img/logo.ico') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    @include('user.includes.style-bundle')
</head>
<body class="bg-gray-100">
    <div class="flex justify-center min-h-screen bg-gray-100" id="app">
        <div class="w-full max-w-md mx-auto bg-white shadow-lg overflow-hidden flex flex-col min-h-screen border border-gray-200 md:my-4 md:min-h-0 md:rounded-xl">
            @include('user.includes.header')
            <main class="overflow-y-auto pt-2 mobile-height">
                @include('includes.validation-errors')
                @yield('content')
            </main>
            @include('user.includes.footer')
        </div>
    </div>

    @include('user.includes.script-bundle')
    @stack('scripts')
</body>
</html>
