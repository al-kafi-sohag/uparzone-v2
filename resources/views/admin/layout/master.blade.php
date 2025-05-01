<!DOCTYPE html>
<html lang="en" data-bs-theme="{{ session('theme', 'light') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @stack('style_links')

    @include('admin.includes.styles')
</head>

<body>
    <div id="app">
        <!-- Sidebar -->
        @if (auth()->guard('admin')->check())
            @include('admin.includes.sidebar')
        @endif

        <!-- Main Content -->
        <div class="main-content {{ !auth()->guard('admin')->check() ? 'ms-0' : '' }}">
            <!-- Header -->
            @include('admin.includes.header')

            <!-- Content -->
            <main>
                @yield('content')
            </main>

            <!-- Footer -->
            @include('admin.includes.footer')
        </div>
    </div>

    <!-- Scripts -->
    @stack('script_links')

    @include('admin.includes.scripts')
</body>

</html>
