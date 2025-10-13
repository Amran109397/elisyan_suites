document.addEventListener('DOMContentLoaded', function () {
    console.log('Dashboard initialized');
    
    // Clear any existing sidebar state completely
    sessionStorage.removeItem('sidebarState');
    localStorage.removeItem('sidebarState');
    
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
            if (userMenu) userMenu.classList.remove('show');
        });
    }

    // User dropdown
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userMenu = document.getElementById('userMenu');

    if (userMenuBtn && userMenu) {
        userMenuBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            userMenu.classList.toggle('show');
            if (notificationMenu) notificationMenu.classList.remove('show');
        });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function () {
        if (notificationMenu) notificationMenu.classList.remove('show');
        if (userMenu) userMenu.classList.remove('show');
    });

    // Force close ALL sections on page load
    setTimeout(() => {
        const allCollapses = document.querySelectorAll('.sidebar-section .collapse');
        allCollapses.forEach(collapse => {
            if (collapse.classList.contains('show')) {
                const bsCollapse = bootstrap.Collapse.getInstance(collapse);
                if (bsCollapse) {
                    bsCollapse.hide();
                } else {
                    new bootstrap.Collapse(collapse, { hide: true });
                }
            }
        });
    }, 150);

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

// Completely disable ALL sidebar state persistence
if (typeof sessionStorage !== 'undefined') {
    sessionStorage.removeItem('sidebarState');
}
if (typeof localStorage !== 'undefined') {
    localStorage.removeItem('sidebarState');
}