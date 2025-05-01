// Theme management
const ThemeManager = {
    init() {
        console.log('Initializing Theme Manager...');
        this.setupTheme();
        this.bindEvents();
        console.log('Theme Manager initialized successfully');
    },

    setupTheme() {
        // Check local storage first
        const savedTheme = localStorage.getItem('theme');
        console.log('Saved theme from localStorage:', savedTheme);

        // If no theme is saved, check system preference
        if (!savedTheme) {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            console.log('No saved theme found. System prefers dark mode:', prefersDark);
            this.setTheme(prefersDark ? 'dark' : 'light');
        } else {
            this.setTheme(savedTheme);
        }
    },

    bindEvents() {
        // Theme toggle click handler
        $('#theme-toggle').on('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            console.log('Theme toggle clicked. Switching from', currentTheme, 'to', newTheme);

            this.setTheme(newTheme);

            // Save theme preference to server using jQuery AJAX
            $.ajax({
                url: '/admin/theme/update',
                method: 'POST',
                data: { theme: newTheme },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (response) => {
                    console.log('Theme preference saved successfully:', response);
                },
                error: (xhr, status, error) => {
                    console.error('Failed to save theme preference:', {
                        status: status,
                        error: error,
                        response: xhr.responseText
                    });
                    // Revert theme if server update fails
                    this.setTheme(currentTheme);
                    // Show error toast if available
                    if (typeof toast !== 'undefined') {
                        toast.error('Failed to save theme preference');
                    }
                }
            });
        });
        console.log('Theme toggle button event listener attached');

        // Listen for system theme changes
        const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        mediaQuery.addEventListener('change', (e) => {
            if (!localStorage.getItem('theme')) {
                console.log('System theme preference changed. Prefers dark mode:', e.matches);
                this.setTheme(e.matches ? 'dark' : 'light');
            }
        });
        console.log('System theme preference change listener attached');
    },

    setTheme(theme) {
        console.log('Setting theme to:', theme);
        document.documentElement.setAttribute('data-bs-theme', theme);
        localStorage.setItem('theme', theme);

        // Update toggle button icon
        const $toggleIcon = $('#theme-toggle svg');
        if ($toggleIcon.length) {
            const newIconClass = theme === 'dark' ? 'bi-moon-stars-fill' : 'bi-sun-fill';
            console.log('Updating theme toggle icon to:', newIconClass);

            // Remove old icon class and add new one
            $toggleIcon.removeClass('bi-sun-fill bi-moon-stars-fill').addClass(newIconClass);

            // Update path data based on theme
            const $path = $toggleIcon.find('path');
            if (theme === 'dark') {
                $path.attr('d', 'M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278M4.858 1.311A7.269 7.269 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.316 7.316 0 0 0 5.205-2.162c-.337.042-.68.063-1.029.063-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286z');
            } else {
                $path.attr('d', 'M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708');
            }
        }
    }
};

// Initialize theme manager when DOM is loaded
$(document).ready(() => {
    console.log('Document ready. Starting Theme Manager...');
    ThemeManager.init();
});
