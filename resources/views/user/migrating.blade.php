@extends('user.layout.master')

@section('title', __('Migrating'))

@push('styles')
<style>
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
    @keyframes progress {
        0% {
            width: 0%;
        }
        100% {
            width: 100%;
        }
    }
    .animate-progress {
        animation: progress 30s linear infinite;
    }
    .data-item {
        animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@section('content')
<div class="p-4 flex flex-col items-center justify-center space-y-6">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ __('Data Migration in Progress') }}</h1>
        <p class="text-gray-600">{{ __('We are transferring your data to the new platform') }}</p>
    </div>

    <!-- Progress Animation -->
    <div class="w-full max-w-md bg-gray-200 rounded-full h-4 overflow-hidden">
        <div class="bg-blue-600 h-4 rounded-full animate-progress"></div>
    </div>

    <!-- Status Card -->
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center mb-4">
            <div class="mr-4">
                <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-800">{{ __('Migration Status') }}</h2>
                <p class="text-sm text-gray-600">{{ __('Please do not close this window') }}</p>
            </div>
        </div>

        <!-- Data Items Being Transferred -->
        <div class="space-y-3 mt-6">
            <div id="profile-data" class="data-item flex items-center p-2 bg-gray-50 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span class="text-gray-700">{{ __('Profile Information') }}</span>
            </div>
            
            <div id="wallet-data" class="data-item flex items-center p-2 bg-gray-50 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2 animate-pulse" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                </svg>
                <span class="text-gray-700">{{ __('Wallet Balance') }}</span>
            </div>
            
            <div id="posts-data" class="data-item flex items-center p-2 bg-gray-50 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-2 animate-pulse" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd" />
                    <path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z" />
                </svg>
                <span class="text-gray-700">{{ __('Posts & Comments') }}</span>
            </div>
            
            <div id="privacy-data" class="data-item flex items-center p-2 bg-gray-50 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500 mr-2 animate-pulse" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                </svg>
                <span class="text-gray-700">{{ __('Privacy Settings') }}</span>
            </div>
            
            <div id="referral-data" class="data-item flex items-center p-2 bg-gray-50 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2 animate-pulse" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                </svg>
                <span class="text-gray-700">{{ __('Referral Information') }}</span>
            </div>
        </div>
    </div>

    <!-- Estimated Time -->
    <div class="text-center">
        <p class="text-sm text-gray-500">{{ __('Estimated time remaining:') }} <span id="countdown">5:00</span></p>
        <p class="text-xs text-gray-400 mt-2">{{ __('You will be automatically redirected when the process completes') }}</p>
    </div>
</div>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Countdown timer
        let minutes = 5;
        let seconds = 0;
        
        const countdownEl = document.getElementById('countdown');
        
        const interval = setInterval(function() {
            if (seconds === 0) {
                if (minutes === 0) {
                    clearInterval(interval);
                    // Redirect or show completion
                    window.location.href = '{{ route("user.home") }}';
                    return;
                }
                minutes--;
                seconds = 59;
            } else {
                seconds--;
            }
            
            countdownEl.textContent = `${minutes}:${seconds < 10 ? '0' + seconds : seconds}`;
        }, 1000);
        
        // Simulate data items being processed
        const dataItems = [
            'profile-data',
            'wallet-data',
            'posts-data',
            'privacy-data',
            'referral-data'
        ];
        
        let currentItem = 0;
        
        // Mark items as completed one by one
        const processInterval = setInterval(function() {
            if (currentItem >= dataItems.length) {
                clearInterval(processInterval);
                return;
            }
            
            const item = document.getElementById(dataItems[currentItem]);
            const icon = item.querySelector('svg');
            
            // Replace with checkmark icon
            icon.innerHTML = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />';
            icon.classList.remove('animate-pulse');
            icon.classList.add('text-green-500');
            
            currentItem++;
        }, 45000 / dataItems.length); // Distribute over most of the countdown time
    });
</script>
@endpush
