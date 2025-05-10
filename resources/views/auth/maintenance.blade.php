@extends('layouts.app')

@section('content')
    <div class="w-full max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden md:max-w-2xl">
        <div class="p-6 md:p-8">
            <!-- Maintenance Icon -->
            <div class="flex justify-center mb-6">
                <div class="relative w-24 h-24 md:w-32 md:h-32">
                    <div class="absolute inset-0 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 md:w-16 md:h-16 text-blue-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="text-center">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">We're Under Maintenance</h1>
                <p class="text-gray-600 mb-6">We're working hard to improve our website and we'll be back soon</p>

                <!-- Estimated Time -->
                <div class="flex items-center justify-center mb-6 text-gray-700">
                    <i data-lucide="clock" class="w-5 h-5 mr-2 text-blue-500"></i>
                    <span>
                        Estimated completion: <span class="font-medium">2 hours</span>
                    </span>
                </div>

                <!-- Contact Info -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <p class="text-sm text-gray-600 mb-2">Need urgent assistance?</p>
                    <div class="flex items-center justify-center text-blue-600">
                        <i data-lucide="mail" class="w-4 h-4 mr-2"></i>
                        <a href="mailto:support@example.com" class="hover:underline">
                            support@example.com
                        </a>
                    </div>
                </div>

                <!-- Updates Button -->
                <a href="https://status.example.com"
                    class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                    <span>Check Status Updates</span>
                    <i data-lucide="arrow-right" class="ml-2 w-4 h-4"></i>
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            <p class="text-center text-sm text-gray-500">
                &copy;
                <script>document.write(new Date().getFullYear())</script> Your Company. All rights reserved.
            </p>
        </div>
    </div>
@endsection
