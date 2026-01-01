// ===============================
// SIDEBAR TOGGLE (GLOBAL SCOPE)
// ===============================
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('mainContent');
    const overlay = document.getElementById('sidebarOverlay');

    if (!sidebar) return;

    if (window.innerWidth >= 992) {
        sidebar.classList.toggle('collapsed');
        content?.classList.toggle('expanded');

        // Tutup semua submenu saat sidebar di-collapse
        if (sidebar.classList.contains('collapsed')) {
            document.querySelectorAll('.submenu.show')
                .forEach(menu => menu.classList.remove('show'));

            document.querySelectorAll('.menu-item.open')
                .forEach(item => item.classList.remove('open'));
        }
    } else {
        sidebar.classList.toggle('mobile-open');
        overlay?.classList.toggle('show');
    }
}

// ===============================
// ICON INIT
// ===============================
lucide.createIcons();

// ===============================
// SIDEBAR MENU LOGIC
// ===============================
document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    const currentPath = window.location.pathname;

    const toggleBtn = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('sidebarOverlay');

    // === TOGGLE SIDEBAR BUTTON ===
    if (toggleBtn) {
        toggleBtn.addEventListener('click', toggleSidebar);
    }

    // === CLOSE SIDEBAR ON OVERLAY CLICK (MOBILE) ===
    if (overlay) {
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('show');
        });
    }

    /* ===============================
       TOGGLE SUBMENU
    =============================== */
    document.querySelectorAll('.menu-item.has-submenu > .menu-link')
        .forEach(menu => {
            menu.addEventListener('click', () => {

                // Jika sidebar collapsed (desktop), expand dulu
                if (window.innerWidth >= 992 && sidebar.classList.contains('collapsed')) {
                    toggleSidebar();
                    setTimeout(() => toggleMenu(menu), 150);
                } else {
                    toggleMenu(menu);
                }
            });
        });

    function toggleMenu(menu) {
        const parent = menu.closest('.menu-item');
        const submenu = parent.querySelector('.submenu');

        // Accordion mode
        document.querySelectorAll('.menu-item.has-submenu')
            .forEach(item => {
                if (item !== parent) {
                    item.classList.remove('open');
                    item.querySelector('.submenu')?.classList.remove('show');
                }
            });

        parent.classList.toggle('open');
        submenu.classList.toggle('show');

        setActiveMenu(menu);
    }

    /* ===============================
       ACTIVE STATE
    =============================== */
    function setActiveMenu(menu) {
        document.querySelectorAll('.menu-link, .submenu-link')
            .forEach(el => el.classList.remove('active'));

        menu.classList.add('active');
    }

    /* ===============================
       ACTIVE SUBMENU BY URL
    =============================== */
    document.querySelectorAll('.submenu-link').forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');

            const parentItem = link.closest('.menu-item');
            parentItem.classList.add('open');
            parentItem.querySelector('.submenu')?.classList.add('show');
            parentItem.querySelector('.menu-link')?.classList.add('active');
        }
    });

    /* ===============================
       MENU TANPA SUBMENU
    =============================== */
    document.querySelectorAll('.menu-item:not(.has-submenu) .menu-link')
        .forEach(menu => {
            menu.addEventListener('click', () => {
                document.querySelectorAll('.menu-link, .submenu-link')
                    .forEach(el => el.classList.remove('active'));

                menu.classList.add('active');
            });
        });
});
