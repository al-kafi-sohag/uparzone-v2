<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <!-- Logo -->
    <div class="p-3 d-flex align-items-center justify-content-between border-bottom">
        <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center text-decoration-none">
            <img src="{{ asset('frontend/img/logo.svg') }}" alt="Logo" class="me-2" width="32" height="32">
            {{-- <span class="fs-4 fw-semibold text-white">{{ config('app.name') }}</span> --}}
        </a>
        <button class="btn icon-button d-lg-none" id="closeSidebar">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="p-3">
        <div class="gap-2 d-flex flex-column">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-house"></i>
                Dashboard
            </a>
        </div>

        <div class="gap-2 d-flex flex-column">
            <a href="{{ route('admin.gender.list') }}"
                class="nav-link {{ request()->routeIs('admin.gender.*') ? 'active' : '' }}">
                <i class="bi bi-gender-male"></i>
                Gender
            </a>
        </div>

        <div class="gap-2 d-flex flex-column">
            <a href="{{ route('admin.mood.list') }}"
                class="nav-link {{ request()->routeIs('admin.mood.*') ? 'active' : '' }}">
                <i class="bi bi-emoji-smile"></i>
                Mood
            </a>
        </div>

        <div class="gap-2 d-flex flex-column">
            <a href="{{ route('admin.post-category.list') }}"
                class="nav-link {{ request()->routeIs('admin.post-category.*') ? 'active' : '' }}">
                <i class="bi bi-folder"></i>
                Post Category
            </a>
        </div>

        <div class="gap-2 d-flex flex-column">
            <a href="{{ route('admin.religion.list') }}"
                class="nav-link {{ request()->routeIs('admin.religion.*') ? 'active' : '' }}">
                <i class="bi bi-book"></i>
                Religion
            </a>
        </div>
    </nav>
</div>

<!-- Mobile Sidebar Backdrop -->
<div class="sidebar-backdrop d-none" id="sidebarBackdrop"></div>
