@extends('layouts.app')

@section('title', 'Welcome to UPARZONE')

@section('content')
    <!-- Logo and Welcome Message -->
    <div class="flex justify-center mb-6">
        <img src="{{ asset('frontend/img/logo.svg') }}" alt="Logo" class="h-20">
    </div>

    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-800">{{ __('Welcome to') }} {{ config('app.name') }}</h1>
        <p class="mt-3 text-gray-600">{{ __('Your social earning network system') }}</p>
    </div>

    <!-- Login Options -->
    <div class="space-y-4 mb-8">
        <!-- Google Login Button -->
        <a href="{{ route('auth.google') }}" class="flex items-center justify-center w-full px-4 py-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                <g transform="matrix(1, 0, 0, 1, 27.009001, -39.238998)">
                    <path fill="#4285F4" d="M -3.264 51.509 C -3.264 50.719 -3.334 49.969 -3.454 49.239 L -14.754 49.239 L -14.754 53.749 L -8.284 53.749 C -8.574 55.229 -9.424 56.479 -10.684 57.329 L -10.684 60.329 L -6.824 60.329 C -4.564 58.239 -3.264 55.159 -3.264 51.509 Z" />
                    <path fill="#34A853" d="M -14.754 63.239 C -11.514 63.239 -8.804 62.159 -6.824 60.329 L -10.684 57.329 C -11.764 58.049 -13.134 58.489 -14.754 58.489 C -17.884 58.489 -20.534 56.379 -21.484 53.529 L -25.464 53.529 L -25.464 56.619 C -23.494 60.539 -19.444 63.239 -14.754 63.239 Z" />
                    <path fill="#FBBC05" d="M -21.484 53.529 C -21.734 52.809 -21.864 52.039 -21.864 51.239 C -21.864 50.439 -21.724 49.669 -21.484 48.949 L -21.484 45.859 L -25.464 45.859 C -26.284 47.479 -26.754 49.299 -26.754 51.239 C -26.754 53.179 -26.284 54.999 -25.464 56.619 L -21.484 53.529 Z" />
                    <path fill="#EA4335" d="M -14.754 43.989 C -12.984 43.989 -11.404 44.599 -10.154 45.789 L -6.734 42.369 C -8.804 40.429 -11.514 39.239 -14.754 39.239 C -19.444 39.239 -23.494 41.939 -25.464 45.859 L -21.484 48.949 C -20.534 46.099 -17.884 43.989 -14.754 43.989 Z" />
                </g>
            </svg>
            {{ __('Continue with Google') }}
        </a>

        <!-- Divider -->
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 text-gray-500 bg-white">{{ __('Or') }}</span>
            </div>
        </div>

        <!-- Manual Login Button -->
        <a href="{{ route('login') }}" class="flex items-center justify-center w-full px-4 py-3 text-base font-medium text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            {{ __('Login with Email') }}
        </a>

        <!-- Register Button -->
        <a href="{{ route('register') }}" class="flex items-center justify-center w-full px-4 py-3 text-base font-medium text-blue-600 bg-white border border-blue-600 rounded-md shadow-sm hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            {{ __('Create an Account') }}
        </a>
    </div>

    <!-- Payment and Advertising Options -->
    <div class="mb-8">
        <h3 class="text-center text-lg font-medium text-gray-700 font-bold mb-4 mt-6">{{ __('Secure Payment Options') }}</h3>
        <div class="flex justify-center mb-4">
            <img src="{{ asset('frontend/img/ssl1024x208.png') }}" alt="Payment Options" class="max-w-full h-auto">
        </div>
        <div class="flex justify-center mb-4">
            <img src="{{ asset('frontend/img/ssl-full-size.png') }}" alt="SSL Certificate" class="max-w-full h-auto">
        </div>
        <h3 class="text-center text-lg font-medium text-gray-700 font-bold mb-4 mt-6">{{ __('Advertising Partners') }}</h3>
        <div class="flex justify-center">
            <img src="{{ asset('frontend/img/adsense.png') }}" alt="Google AdSense" class="max-w-full h-auto max-h-24">
        </div>
    </div>

    <!-- Footer -->
    <footer class="pt-8 mt-10 bg-gray-900 text-white rounded-t-lg shadow-lg">
        <div class="px-6 py-8">
            <!-- About Section - Outside Accordion -->
            <div class="text-center mb-8">
                <h3 class="text-xl font-bold text-blue-400 mb-4">{{ __('About') }} {{ config('app.name') }}</h3>
                <p class="text-gray-300 mb-4 max-w-2xl mx-auto">{{ __('A social earning network system that helps you connect and earn through various opportunities.') }}</p>
                <div class="flex justify-center space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                            <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                            <rect x="2" y="9" width="4" height="12"></rect>
                            <circle cx="4" cy="4" r="2"></circle>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Accordion Sections -->
            <div class="max-w-2xl mx-auto">
                <!-- Quick Links Accordion -->
                <div class="border-b border-gray-700">
                    <button class="accordion-btn flex items-center justify-between w-full py-4 text-left" data-target="quickLinks">
                        <h3 class="text-lg font-bold text-blue-400">{{ __('Quick Links') }}</h3>
                        <svg id="quickLinksIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-400 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="quickLinks" class="hidden overflow-hidden transition-all duration-300 pb-4">
                        <ul class="space-y-2 pl-2">
                            <li class="pb-2"><a href="#" class="w-100 d-block pt-2 pb-2 pl-2 bg-gray-800 border border-gray-700 text-gray-300 hover:text-white hover:underline transition-colors duration-300">{{ __('Home') }}</a></li>
                            <li class="pb-2"><a href="#" class="w-100 d-block pt-2 pb-2 pl-2 bg-gray-800 border border-gray-700 text-gray-300 hover:text-white hover:underline transition-colors duration-300">{{ __('About Us') }}</a></li>
                            <li class="pb-2"><a href="#" class="w-100 d-block pt-2 pb-2 pl-2 bg-gray-800 border border-gray-700 text-gray-300 hover:text-white hover:underline transition-colors duration-300">{{ __('Services') }}</a></li>
                            <li class="pb-2"><a href="#" class="w-100 d-block pt-2 pb-2 pl-2 bg-gray-800 border border-gray-700 text-gray-300 hover:text-white hover:underline transition-colors duration-300">{{ __('Contact') }}</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Legal Accordion -->
                <div class="">
                    <button class="accordion-btn flex items-center justify-between w-full py-4 text-left" data-target="legal">
                        <h3 class="text-lg font-bold text-blue-400">{{ __('Legal') }}</h3>
                        <svg id="legalIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-400 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="legal" class="hidden overflow-hidden transition-all duration-300 pb-4">
                        <ul class="space-y-2 pl-2">
                            <li class="pb-2"><a href="#" class="w-100 d-block pt-2 pb-2 pl-2 bg-gray-800 border border-gray-700 text-gray-300 hover:text-white hover:underline transition-colors duration-300">{{ __('Terms of Service') }}</a></li>
                            <li class="pb-2"><a href="#" class="w-100 d-block pt-2 pb-2 pl-2 bg-gray-800 border border-gray-700 text-gray-300 hover:text-white hover:underline transition-colors duration-300">{{ __('Privacy Policy') }}</a></li>
                            <li class="pb-2"><a href="#" class="w-100 d-block pt-2 pb-2 pl-2 bg-gray-800 border border-gray-700 text-gray-300 hover:text-white hover:underline transition-colors duration-300">{{ __('Refund Policy') }}</a></li>
                            <li class="pb-2"><a href="#" class="w-100 d-block pt-2 pb-2 pl-2 bg-gray-800 border border-gray-700 text-gray-300 hover:text-white hover:underline transition-colors duration-300">{{ __('Cookie Policy') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-700 mb-6"></div>

            <!-- Copyright -->
            <div class="text-center text-gray-400 text-sm">
                <p>© {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}</p>
                <p class="mt-2">{{ __('Designed with') }} <span class="text-red-500">♥</span> {{ __('for our users') }}</p>
            </div>
        </div>
    </footer>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        function toggleAccordion(id) {
            const $content = $('#' + id);
            const $icon = $('#' + id + 'Icon');

            if ($content.hasClass('hidden')) {
                $content.removeClass('hidden');
                $content.css('opacity', 0)
                    .slideDown(300)
                    .animate({ opacity: 1 }, 300);
                $icon.addClass('rotate-180');
            } else {
                $content.animate({ opacity: 0 }, 300, function() {
                    $(this).slideUp(300, function() {
                        $(this).addClass('hidden');
                    });
                });
                $icon.removeClass('rotate-180');
            }
        }

        // Attach click event to accordion buttons
        $('.accordion-btn').on('click', function() {
            const id = $(this).data('target');
            toggleAccordion(id);
        });
    });
</script>
@endpush
