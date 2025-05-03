<header class="sticky top-0 z-10 bg-white border-b border-gray-200">
    <div class="px-4">
        <div class="flex justify-between items-center h-14">
            <!-- Logo (U shape) -->
            <div class="flex items-center">
                <a href="{{ route('user.home') }}" class="text-2xl font-bold text-black">
                    <img src="{{ asset('user/img/logo.svg') }}" alt="" class="navbar_logo"
                        style="height: 3rem;width: 100%;">
                </a>
            </div>

            <!-- Time -->
            <div class="flex items-center">
                <i data-lucide="clock" class="mr-1"></i>
                <span class="text-sm" id="timer"></span>
            </div>

            {{-- <div class="flex items-center">
                <i id="repeatIcon" class="fa-solid fa-repeat" onclick="toggleNavAndRotate()"></i>
            </div> --}}

            <!-- Counter and Chat -->
            <div class="flex items-center space-x-3">
                <div class="flex items-center">
                    <i data-lucide="wallet"></i>
                    @if (Auth::user()->wallet == 200 && Auth::user()->premium == 'inactive')
                        <a href="" class="flex-auto items-center ml-2">
                            <p style="color: red; margin-top:10px">
                                200tk <i data-lucide="lock"></i>
                            </p>
                        </a>
                    @else
                        <a href="" class="flex-auto items-center ml-2">
                            <span class="itemsz">
                                <span id="balance" class="balance-text">{{ number_format(Auth::user()->wallet, 2) }} tk</span>
                            </span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>
