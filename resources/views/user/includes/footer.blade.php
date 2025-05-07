<div class="flex fixed right-0 bottom-0 left-0 justify-center">
    <div class="w-full max-w-md bg-white border-t border-gray-200 shadow-lg">
        <footer class="flex justify-center items-center px-2 h-16">
            <!-- Home Icon -->
            <div class="flex flex-1 justify-center">
                <a href="{{ route('user.home') }}" class="flex flex-col items-center">
                    <div class="homIcon">
                        <i data-lucide="home" class="w-6 h-6 text-gray-700"></i>
                    </div>
                </a>
            </div>

            <!-- Reels Icon -->
            <div class="flex flex-1 justify-center">
                <a href="" class="flex flex-col items-center">
                    <div class="homIcon">
                        <i data-lucide="film" class="w-6 h-6 text-gray-700"></i>
                    </div>
                </a>
            </div>

            <!-- Profile -->
            <div class="flex flex-1 justify-center" style="width: 120px;">
                <a href="{{ route('user.profile') }}" class="flex flex-col items-center text-gray-700 no-underline">
                    <div class="overflow-hidden relative mb-1 w-8 h-8 bg-gray-200 rounded-full">
                        <img src="{{ profile_img(user()->profile_img) }}" alt="Profile"
                            class="object-cover absolute inset-0 w-full h-full" width="32" height="32">
                    </div>
                    <p class="w-16 text-xs text-center truncate">{{ str_limit(user()->name, 10, '...') }}</p>
                </a>
            </div>

            <!-- Mood Icon -->
            <div class="flex flex-1 justify-center">
                <a href="" class="flex flex-col items-center">
                    <div class="homIcon">
                        <i data-lucide="smile" class="w-6 h-6 text-gray-700"></i>
                    </div>
                </a>
            </div>

            <!-- More Icon -->
            <div class="flex flex-1 justify-center">
                <a href="javascript:void(0)" id="openDrawerBtn" class="flex flex-col items-center">
                    <div class="homIcon">
                        <i data-lucide="more-horizontal" class="w-6 h-6 text-gray-700"></i>
                    </div>
                </a>
            </div>
        </footer>
    </div>
</div>

<!-- Slide-over panel -->
<div id="slideOverPanel" class="relative z-10 hidden" aria-labelledby="slide-over-title" role="dialog"
    aria-modal="true">
    <!-- Background backdrop -->
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity ease-in-out duration-500 opacity-0"
        id="slideOverBackdrop" aria-hidden="true"></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <!-- Slide-over panel -->
                <div class="pointer-events-auto relative w-screen max-w-md transform transition ease-in-out duration-500 sm:duration-700 translate-x-full"
                    id="slideOverContent">
                    <!-- Close button -->
                    <div class="absolute top-0 left-0 -ml-8 flex pt-4 pr-2 sm:-ml-10 sm:pr-4 opacity-0 ease-in-out duration-500"
                        id="slideOverCloseBtn">
                        <button type="button"
                            class="relative rounded-md text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                            <span class="absolute -inset-2.5"></span>
                            <span class="sr-only">Close panel</span>
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>

                    <div class="flex h-full flex-col overflow-y-scroll bg-white py-6 shadow-xl">
                        <div class="px-4 sm:px-6">
                            <h2 class="text-base font-semibold text-gray-900" id="slide-over-title">{{ __('Menu') }}</h2>
                        </div>
                        <div class="relative mt-6 flex-1 px-4 sm:px-6">
                            <ul class="space-y-2 font-medium">
                                <li>
                                    <a href="{{ route('user.profile') }}" type="button"
                                        class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100">
                                        <i data-lucide="user" class="w-5 h-5 text-gray-500"></i>
                                        <span class="ml-3">{{ __('Profile') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('user.wallet') }}" type="button"
                                        class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100">
                                        <i data-lucide="wallet" class="w-5 h-5 text-gray-500"></i>
                                        <span class="ml-3">{{ __('Wallet') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" onclick="document.getElementById('logout-form').submit();" type="button"
                                        class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100">
                                        <i data-lucide="log-out" class="w-5 h-5 text-gray-500"></i>
                                        <span class="ml-3">{{ __('Logout') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('user.includes.logout-form')
