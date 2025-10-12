document.addEventListener('DOMContentLoaded', function () {
    console.log('Dashboard initialized');
    
    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const sidebar = document.getElementById('sidebar');

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function () {
            sidebar.classList.toggle('active');
        });
    }

    // Notification dropdown
    const notificationBtn = document.getElementById('notificationBtn');
    const notificationMenu = document.getElementById('notificationMenu');

    if (notificationBtn && notificationMenu) {
        notificationBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            notificationMenu.classList.toggle('show');
            userMenu.classList.remove('show');
        });
    }

    // User dropdown
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userMenu = document.getElementById('userMenu');

    if (userMenuBtn && userMenu) {
        userMenuBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            userMenu.classList.toggle('show');
            notificationMenu.classList.remove('show');
        });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function () {
        if (notificationMenu) notificationMenu.classList.remove('show');
        if (userMenu) userMenu.classList.remove('show');
    });

    // SIMPLE SIDEBAR STATE MANAGEMENT
    initializeSidebarState();

    // Initialize revenue chart
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        const revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Revenue',
                    data: [12000, 19000, 15000, 25000, 22000, 30000, 28000],
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }
});

// SIMPLE SIDEBAR STATE MANAGEMENT
function initializeSidebarState() {
    // Load previous state
    loadSidebarState();
    
    // Save state when any navigation happens
    document.addEventListener('click', function(e) {
        if (e.target.closest('.subsection-link') || e.target.closest('.sub-submenu-item')) {
            setTimeout(saveSidebarState, 100);
        }
    });
    
    // Save state when collapse changes (Bootstrap events)
    document.addEventListener('show.bs.collapse', saveSidebarState);
    document.addEventListener('hide.bs.collapse', saveSidebarState);
}

function saveSidebarState() {
    const state = {
        // Save which sections are open
        openSections: Array.from(document.querySelectorAll('.sidebar-section .collapse.show'))
            .map(collapse => collapse.id),
        // Save scroll position
        scrollPosition: document.querySelector('.sidebar-content')?.scrollTop || 0,
        timestamp: Date.now()
    };
    
    sessionStorage.setItem('sidebarState', JSON.stringify(state));
}

function loadSidebarState() {
    try {
        const saved = sessionStorage.getItem('sidebarState');
        if (!saved) return;
        
        const state = JSON.parse(saved);
        
        // Only restore if less than 30 minutes old
        if (Date.now() - state.timestamp > 30 * 60 * 1000) return;
        
        // Close all sections first
        document.querySelectorAll('.sidebar-section .collapse').forEach(collapse => {
            const bsCollapse = bootstrap.Collapse.getInstance(collapse);
            if (bsCollapse) bsCollapse.hide();
        });
        
        // Open saved sections
        state.openSections.forEach(sectionId => {
            const collapse = document.getElementById(sectionId);
            if (collapse) {
                const bsCollapse = bootstrap.Collapse.getInstance(collapse) || 
                                  new bootstrap.Collapse(collapse, { toggle: false });
                bsCollapse.show();
            }
        });
        
        // Restore scroll position
        setTimeout(() => {
            const sidebarContent = document.querySelector('.sidebar-content');
            if (sidebarContent && state.scrollPosition) {
                sidebarContent.scrollTop = state.scrollPosition;
            }
        }, 200);
        
    } catch (error) {
        console.log('Error loading sidebar state:', error);
    }
}

// Handle page navigation
window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
        setTimeout(loadSidebarState, 100);
    }
});