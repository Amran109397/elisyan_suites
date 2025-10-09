document.addEventListener('DOMContentLoaded', function () {
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

            // Close user menu if open
            const userMenu = document.getElementById('userMenu');
            if (userMenu) {
                userMenu.classList.remove('show');
            }
        });
    }

    // User dropdown
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userMenu = document.getElementById('userMenu');

    if (userMenuBtn && userMenu) {
        userMenuBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            userMenu.classList.toggle('show');

            // Close notification menu if open
            if (notificationMenu) {
                notificationMenu.classList.remove('show');
            }
        });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function () {
        if (notificationMenu) {
            notificationMenu.classList.remove('show');
        }
        if (userMenu) {
            userMenu.classList.remove('show');
        }
    });

    // Role-based dashboard functionality
    const roleSelector = document.getElementById('roleSelector');

    if (roleSelector) {
        roleSelector.addEventListener('change', function () {
            const selectedRole = this.value;
            updateDashboardForRole(selectedRole);
            updateRoleIndicator(selectedRole);
        });

        // Initialize with default role
        updateDashboardForRole('super_admin');
        updateRoleIndicator('super_admin');
    }

    function updateDashboardForRole(role) {
        // Hide all role-specific elements
        document.querySelectorAll('[data-role]').forEach(el => {
            el.classList.remove('visible');
        });

        // Show elements for selected role
        document.querySelectorAll(`[data-role*="${role}"], [data-role="all"]`).forEach(el => {
            el.classList.add('visible');
        });

        // Update sidebar navigation
        updateSidebarForRole(role);

        // Update dashboard content
        updateDashboardContentForRole(role);

        // Update stats cards
        updateStatsForRole(role);
    }

    function updateRoleIndicator(role) {
        const pageTitle = document.querySelector('.page-title');
        if (pageTitle) {
            // Remove existing role indicator
            const existingIndicator = pageTitle.querySelector('.role-indicator');
            if (existingIndicator) {
                existingIndicator.remove();
            }

            // Add new role indicator
            const indicator = document.createElement('span');
            indicator.className = `role-indicator role-${role}`;
            indicator.textContent = role.replace('_', ' ').toUpperCase();
            pageTitle.appendChild(indicator);
        }
    }

    function updateSidebarForRole(role) {
        const rolePermissions = {
            super_admin: ['all'],
            property_manager: ['front-desk', 'room-management', 'financial', 'pos', 'inventory', 'reports', 'system-admin', 'guest-relations', 'channel-management', 'events', 'asset-management'],
            receptionist: ['front-desk', 'room-management'],
            housekeeping: ['housekeeping'],
            pos_staff: ['pos'],
            maintenance: ['housekeeping']
        };

        document.querySelectorAll('.sidebar-section').forEach(section => {
            const sectionId = section.id;
            const hasPermission = rolePermissions[role].includes('all') ||
                rolePermissions[role].includes(sectionId);

            if (hasPermission) {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        });
    }

    function updateDashboardContentForRole(role) {
        // Update welcome message
        const welcomeMessage = document.querySelector('.welcome-message');
        if (welcomeMessage) {
            const messages = {
                super_admin: 'Welcome to Hotel Management System - Super Admin Dashboard',
                property_manager: 'Welcome to Property Management Dashboard',
                receptionist: 'Welcome to Front Desk Operations',
                housekeeping: 'Welcome to Housekeeping Management',
                pos_staff: 'Welcome to POS Operations',
                maintenance: 'Welcome to Maintenance Management'
            };
            welcomeMessage.textContent = messages[role] || 'Welcome to Dashboard';
        }

        // Update quick actions visibility
        document.querySelectorAll('.quick-action').forEach(action => {
            const actionRoles = action.getAttribute('data-role');
            if (actionRoles && actionRoles.includes(role)) {
                action.classList.add('visible');
            } else {
                action.classList.remove('visible');
            }
        });

        // Update activity feed based on role
        updateActivityFeedForRole(role);
    }

    function updateStatsForRole(role) {
        const roleStats = {
            super_admin: [
                { icon: 'fas fa-building', value: '3', label: 'Properties', color: 'primary' },
                { icon: 'fas fa-users', value: '45', label: 'Total Users', color: 'info' },
                { icon: 'fas fa-chart-line', value: '$125K', label: 'Total Revenue', color: 'success' },
                { icon: 'fas fa-door-open', value: '145', label: 'Total Rooms', color: 'warning' }
            ],
            property_manager: [
                { icon: 'fas fa-door-open', value: '145', label: 'Total Rooms', color: 'primary' },
                { icon: 'fas fa-chart-bar', value: '78%', label: 'Occupancy Rate', color: 'success' },
                { icon: 'fas fa-dollar-sign', value: '$12,450', label: "Today's Revenue", color: 'info' },
                { icon: 'fas fa-sign-in-alt', value: '24', label: "Today's Check-ins", color: 'warning' }
            ],
            receptionist: [
                { icon: 'fas fa-calendar-check', value: '12', label: "Today's Check-ins", color: 'success' },
                { icon: 'fas fa-sign-out-alt', value: '8', label: "Today's Check-outs", color: 'info' },
                { icon: 'fas fa-list', value: '5', label: 'Pending Bookings', color: 'warning' },
                { icon: 'fas fa-users', value: '3', label: 'Waiting List', color: 'danger' }
            ],
            housekeeping: [
                { icon: 'fas fa-broom', value: '24', label: 'Completed Tasks', color: 'success' },
                { icon: 'fas fa-tasks', value: '8', label: 'In Progress', color: 'warning' },
                { icon: 'fas fa-exclamation-triangle', value: '3', label: 'Urgent Tasks', color: 'danger' },
                { icon: 'fas fa-check-circle', value: '95%', label: 'Completion Rate', color: 'info' }
            ],
            pos_staff: [
                { icon: 'fas fa-shopping-cart', value: '45', label: 'Today\'s Orders', color: 'primary' },
                { icon: 'fas fa-dollar-sign', value: '$3,250', label: 'Today\'s Revenue', color: 'success' },
                { icon: 'fas fa-utensils', value: '12', label: 'Active Tables', color: 'info' },
                { icon: 'fas fa-clock', value: '15', label: 'Pending Orders', color: 'warning' }
            ],
            maintenance: [
                { icon: 'fas fa-tools', value: '8', label: 'Open Issues', color: 'danger' },
                { icon: 'fas fa-wrench', value: '5', label: 'In Progress', color: 'warning' },
                { icon: 'fas fa-check', value: '12', label: 'Completed Today', color: 'success' },
                { icon: 'fas fa-calendar', value: '3', label: 'Scheduled', color: 'info' }
            ]
        };

        const statsContainer = document.querySelector('.stats-container .row');
        if (statsContainer && roleStats[role]) {
            statsContainer.innerHTML = '';

            roleStats[role].forEach(stat => {
                const statCol = document.createElement('div');
                statCol.className = 'col-xl-3 col-md-6 mb-4';
                statCol.innerHTML = `
                    <div class="stat-card ${stat.color}">
                        <div class="stat-card-body">
                            <div class="stat-icon">
                                <i class="${stat.icon}"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">${stat.value}</div>
                                <div class="stat-label">${stat.label}</div>
                            </div>
                        </div>
                    </div>
                `;
                statsContainer.appendChild(statCol);
            });
        }
    }

    function updateActivityFeedForRole(role) {
        const roleActivities = {
            super_admin: [
                { icon: 'fas fa-user-plus', color: 'primary', title: 'New user registered - Property Manager', time: '5 minutes ago' },
                { icon: 'fas fa-building', color: 'info', title: 'New property added - Downtown Hotel', time: '15 minutes ago' },
                { icon: 'fas fa-chart-line', color: 'success', title: 'Monthly revenue target achieved', time: '1 hour ago' },
                { icon: 'fas fa-shield-alt', color: 'warning', title: 'Security audit completed', time: '2 hours ago' },
                { icon: 'fas fa-database', color: 'danger', title: 'Database backup completed', time: '3 hours ago' }
            ],
            property_manager: [
                { icon: 'fas fa-chart-line', color: 'success', title: 'Occupancy rate increased to 78%', time: '10 minutes ago' },
                { icon: 'fas fa-dollar-sign', color: 'primary', title: 'Monthly revenue target achieved', time: '30 minutes ago' },
                { icon: 'fas fa-users', color: 'info', title: 'New staff member joined', time: '1 hour ago' },
                { icon: 'fas fa-star', color: 'warning', title: 'Guest satisfaction score updated', time: '2 hours ago' },
                { icon: 'fas fa-clipboard-check', color: 'success', title: 'Monthly report generated', time: '3 hours ago' }
            ],
            receptionist: [
                { icon: 'fas fa-calendar-check', color: 'primary', title: 'New booking received - Room 201', time: '5 minutes ago' },
                { icon: 'fas fa-sign-in-alt', color: 'success', title: 'Guest checked in - Room 305', time: '15 minutes ago' },
                { icon: 'fas fa-phone', color: 'info', title: 'Phone reservation received', time: '30 minutes ago' },
                { icon: 'fas fa-exclamation-triangle', color: 'warning', title: 'Guest complaint - Room 104', time: '1 hour ago' },
                { icon: 'fas fa-credit-card', color: 'success', title: 'Payment received - Booking #1234', time: '2 hours ago' }
            ],
            housekeeping: [
                { icon: 'fas fa-broom', color: 'success', title: 'Room cleaning completed - 201', time: '10 minutes ago' },
                { icon: 'fas fa-tasks', color: 'warning', title: 'New cleaning task assigned - 305', time: '20 minutes ago' },
                { icon: 'fas fa-tools', color: 'danger', title: 'Maintenance issue reported - 104', time: '30 minutes ago' },
                { icon: 'fas fa-check', color: 'success', title: 'Inspection completed - 201', time: '45 minutes ago' },
                { icon: 'fas fa-clock', color: 'info', title: 'Turndown service scheduled', time: '1 hour ago' }
            ],
            pos_staff: [
                { icon: 'fas fa-shopping-cart', color: 'primary', title: 'New order received - Table 5', time: '5 minutes ago' },
                { icon: 'fas fa-utensils', color: 'success', title: 'Order completed - Table 3', time: '15 minutes ago' },
                { icon: 'fas fa-credit-card', color: 'info', title: 'Payment processed - Table 7', time: '20 minutes ago' },
                { icon: 'fas fa-exclamation-triangle', color: 'warning', title: 'Low stock alert - Coffee', time: '30 minutes ago' },
                { icon: 'fas fa-room-service', color: 'success', title: 'Room service delivered - 201', time: '45 minutes ago' }
            ],
            maintenance: [
                { icon: 'fas fa-tools', color: 'danger', title: 'Urgent maintenance - AC Room 304', time: '5 minutes ago' },
                { icon: 'fas fa-wrench', color: 'warning', title: 'In progress - Plumbing Room 105', time: '15 minutes ago' },
                { icon: 'fas fa-check', color: 'success', title: 'Completed - Electrical Room 201', time: '30 minutes ago' },
                { icon: 'fas fa-calendar', color: 'info', title: 'Scheduled maintenance - Elevator', time: '1 hour ago' },
                { icon: 'fas fa-clipboard-list', color: 'primary', title: 'New work order created', time: '2 hours ago' }
            ]
        };

        const activityFeed = document.querySelector('.activity-feed');
        if (activityFeed && roleActivities[role]) {
            activityFeed.innerHTML = '';

            roleActivities[role].forEach(activity => {
                const activityItem = document.createElement('div');
                activityItem.className = 'activity-item';
                activityItem.innerHTML = `
                    <div class="activity-icon bg-${activity.color}">
                        <i class="${activity.icon}"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">${activity.title}</div>
                        <div class="activity-time">${activity.time}</div>
                    </div>
                `;
                activityFeed.appendChild(activityItem);
            });
        }
    }

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
                plugins: {
                    legend: {
                        display: false
                    }
                },
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

    // Simulate real-time updates
    setInterval(function () {
        // Update random metric
        const metrics = document.querySelectorAll('.stat-value');
        if (metrics.length > 0) {
            const randomMetric = metrics[Math.floor(Math.random() * metrics.length)];
            const currentValue = randomMetric.textContent;

            // Handle different value types
            if (currentValue.includes('$')) {
                const numericValue = parseInt(currentValue.replace(/[^0-9]/g, ''));
                const change = Math.floor(Math.random() * 1000) - 500;
                randomMetric.textContent = '$' + (numericValue + change).toLocaleString();
            } else if (currentValue.includes('%')) {
                const numericValue = parseInt(currentValue.replace(/[^0-9]/g, ''));
                const change = Math.floor(Math.random() * 10) - 5;
                const newValue = Math.max(0, Math.min(100, numericValue + change));
                randomMetric.textContent = newValue + '%';
            } else {
                const numericValue = parseInt(currentValue.replace(/[^0-9]/g, ''));
                const change = Math.floor(Math.random() * 5) - 2;
                randomMetric.textContent = Math.max(0, numericValue + change);
            }
        }

        // Add new activity based on current role
        const currentRole = document.getElementById('roleSelector').value;
        const activities = {
            super_admin: [
                { icon: 'fas fa-user-plus', color: 'primary', title: 'New user registered' },
                { icon: 'fas fa-building', color: 'info', title: 'New property added' },
                { icon: 'fas fa-chart-line', color: 'success', title: 'Revenue target achieved' },
                { icon: 'fas fa-shield-alt', color: 'warning', title: 'Security audit completed' },
                { icon: 'fas fa-database', color: 'danger', title: 'Database backup completed' }
            ],
            property_manager: [
                { icon: 'fas fa-chart-line', color: 'success', title: 'Occupancy rate updated' },
                { icon: 'fas fa-dollar-sign', color: 'primary', title: 'Revenue milestone reached' },
                { icon: 'fas fa-users', color: 'info', title: 'Staff performance updated' },
                { icon: 'fas fa-star', color: 'warning', title: 'Guest satisfaction updated' },
                { icon: 'fas fa-clipboard-check', color: 'success', title: 'Report generated' }
            ],
            receptionist: [
                { icon: 'fas fa-calendar-check', color: 'primary', title: 'New booking received' },
                { icon: 'fas fa-sign-in-alt', color: 'success', title: 'Guest checked in' },
                { icon: 'fas fa-sign-out-alt', color: 'info', title: 'Guest checked out' },
                { icon: 'fas fa-tools', color: 'warning', title: 'Maintenance issue reported' },
                { icon: 'fas fa-credit-card', color: 'success', title: 'Payment received' }
            ],
            housekeeping: [
                { icon: 'fas fa-broom', color: 'success', title: 'Room cleaning completed' },
                { icon: 'fas fa-tasks', color: 'warning', title: 'New task assigned' },
                { icon: 'fas fa-tools', color: 'danger', title: 'Maintenance issue reported' },
                { icon: 'fas fa-check', color: 'success', title: 'Inspection completed' },
                { icon: 'fas fa-clock', color: 'info', title: 'Service scheduled' }
            ],
            pos_staff: [
                { icon: 'fas fa-shopping-cart', color: 'primary', title: 'New order received' },
                { icon: 'fas fa-utensils', color: 'success', title: 'Order completed' },
                { icon: 'fas fa-credit-card', color: 'info', title: 'Payment processed' },
                { icon: 'fas fa-exclamation-triangle', color: 'warning', title: 'Low stock alert' },
                { icon: 'fas fa-room-service', color: 'success', title: 'Room service delivered' }
            ],
            maintenance: [
                { icon: 'fas fa-tools', color: 'danger', title: 'Urgent maintenance reported' },
                { icon: 'fas fa-wrench', color: 'warning', title: 'Maintenance in progress' },
                { icon: 'fas fa-check', color: 'success', title: 'Maintenance completed' },
                { icon: 'fas fa-calendar', color: 'info', title: 'Maintenance scheduled' },
                { icon: 'fas fa-clipboard-list', color: 'primary', title: 'Work order created' }
            ]
        };

        const roleActivities = activities[currentRole] || activities.super_admin;
        const randomActivity = roleActivities[Math.floor(Math.random() * roleActivities.length)];
        const activityFeed = document.querySelector('.activity-feed');

        if (activityFeed) {
            const newActivity = document.createElement('div');
            newActivity.className = 'activity-item';
            newActivity.innerHTML = `
                <div class="activity-icon bg-${randomActivity.color}">
                    <i class="${randomActivity.icon}"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-title">${randomActivity.title}</div>
                    <div class="activity-time">Just now</div>
                </div>
            `;

            // Add to the top
            activityFeed.insertBefore(newActivity, activityFeed.firstChild);

            // Remove oldest activity if more than 5
            if (activityFeed.children.length > 5) {
                activityFeed.removeChild(activityFeed.lastChild);
            }
        }
    }, 10000); // Update every 10 seconds
});