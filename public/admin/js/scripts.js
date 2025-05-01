document.addEventListener('DOMContentLoaded', function() {
    // Mobile sidebar toggle
    const toggleSidebarBtn = document.getElementById('toggleSidebar');
    const closeSidebarBtn = document.getElementById('closeSidebar');
    const sidebar = document.querySelector('.sidebar');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');

    // Toggle sidebar open
    if (toggleSidebarBtn && sidebar) {
        toggleSidebarBtn.addEventListener('click', () => {
            sidebar.classList.add('show');
            sidebarBackdrop.classList.remove('d-none');
            document.body.style.overflow = 'hidden'; // Prevent scrolling when sidebar is open
        });
    }

    // Close sidebar
    if (closeSidebarBtn && sidebar) {
        closeSidebarBtn.addEventListener('click', () => {
            sidebar.classList.remove('show');
            sidebarBackdrop.classList.add('d-none');
            document.body.style.overflow = ''; // Restore scrolling
        });
    }

    // Close sidebar when clicking on backdrop
    if (sidebarBackdrop) {
        sidebarBackdrop.addEventListener('click', () => {
            sidebar.classList.remove('show');
            sidebarBackdrop.classList.add('d-none');
            document.body.style.overflow = ''; // Restore scrolling
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 992) { // Using 992px to match Bootstrap's lg breakpoint
            if (sidebar && sidebar.classList.contains('show') && 
                !sidebar.contains(e.target) && 
                !toggleSidebarBtn.contains(e.target)) {
                sidebar.classList.remove('show');
                if (sidebarBackdrop) {
                    sidebarBackdrop.classList.add('d-none');
                }
                document.body.style.overflow = ''; // Restore scrolling
            }
        }
    });

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
});

// Slug Generator
function generateSlug(str) {
    return str
        .toLowerCase()
        .replace(/\s+/g, "-")
        .replace(/[^\w\u0980-\u09FF-]+/g, "") // Allow Bangla characters (\u0980-\u09FF)
        .replace(/--+/g, "-")
        .replace(/^-+|-+$/g, "");
}

$(document).ready(function () {
    $("#title").on("keyup", function () {
        const titleValue = $(this).val().trim();
        const slugValue = generateSlug(titleValue);
        $("#slug").val(slugValue);
    });
});
