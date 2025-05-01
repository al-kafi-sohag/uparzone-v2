<header class="header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between">
            <!-- Mobile menu button -->
            <button class="btn icon-button d-lg-none" id="toggleSidebar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>

            <!-- Right section -->
            <div class="d-flex align-items-center gap-3 ms-auto">
                <!-- Dark mode toggle -->
                <button class="btn icon-button" id="theme-toggle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi {{ session('theme', 'light') === 'dark' ? 'bi-moon-stars-fill' : 'bi-sun-fill' }}"
                        viewBox="0 0 16 16">
                        <!-- Sun icon -->
                        <path
                            d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708" />
                    </svg>
                </button>

                {{-- <!-- Notifications -->
                <div class="dropdown">
                    <button class="btn icon-button" data-bs-toggle="dropdown">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <div class="p-3 text-center text-muted">
                            No new notifications
                        </div>
                    </div>
                </div> --}}

                @if (auth()->guard('admin')->check())
                    <!-- Profile dropdown -->
                    <div class="dropdown profile-dropdown">
                        <button class="btn d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                            <img class="rounded-circle" width="32" height="32"
                                src="https://ui-avatars.com/api/?name={{ urlencode(auth()->guard('admin')->user()->name) }}&background=0D8ABC&color=fff"
                                alt="{{ auth()->guard('admin')->user()->name }}">
                            <span class="d-none d-md-block">{{ auth()->guard('admin')->user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="dropdown-header">
                                <div class="fw-medium">{{ auth()->guard('admin')->user()->name }}</div>
                                <div class="text-muted">{{ auth()->guard('admin')->user()->email }}</div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Sign out</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</header>
