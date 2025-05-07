<header class="sticky top-0 z-10 bg-white border-b border-gray-200">
    <div class="px-4">
        <div class="flex justify-between items-center h-14">
            <!-- Logo (U shape) -->
            <div class="flex items-center">
                <a href="{{ route('user.home') }}" class="text-2xl font-bold text-black">
                    <img src="{{ asset('user/img/logo.svg') }}" alt="" class="navbar_logo"
                        style="height: 2.5rem;width: 100%;">
                </a>
            </div>

            <!-- Time -->
            <div class="flex items-center">
                <i data-lucide="clock" class="mr-1"></i>
                <span class="text-sm" id="timer">{{ formatTime($active_time) }}</span>
            </div>

            {{-- <div class="flex items-center">
                <i id="repeatIcon" class="fa-solid fa-repeat" onclick="toggleNavAndRotate()"></i>
            </div> --}}

            <!-- Counter and Chat -->
            <div class="flex items-center space-x-3">
                <div class="flex items-center">
                    @if ($balance > 200 && Auth::user()->is_premium == false)
                        <i data-lucide="lock" class="mr-1 text-red-500"></i>
                        <a href="" class="flex-auto items-center ml-2">
                            <p class="flex items-center justify-between gap-1 text-red-500">
                                <span id="balance" class="balance-text">{{ number_format($balance, 2) }}</span> tk
                            </p>
                        </a>
                    @else
                        <i data-lucide="wallet" class="mr-1 text-green-500"></i>
                        <a href="" class="flex-auto items-center ml-2">
                            <span class="itemsz flex items-center justify-between gap-1">
                                <span id="balance" class="balance-text">{{ number_format($balance, 2) }}</span> tk
                            </span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="w-full bg-gray-200 h-1">
        <div id="time-tracking-bar" class="bg-teal-600 h-1">
        </div>
    </div>
</header>
