<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="min-h-screen bg-gray-100">
    <div class="relative flex flex-col w-full max-w-md mx-auto bg-white border-gray-200 border-x md:my-4 md:min-h-0 md:rounded-xl md:max-h-[800px]" id="app">
        <main class="flex-grow p-4">
            <div class="w-full max-w-md mx-auto">
                @include('includes.validation-errors')
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
