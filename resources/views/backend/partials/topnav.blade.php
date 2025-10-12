<nav class="top-nav">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="mobile-menu-btn d-md-none" id="mobileMenuBtn">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title">Dashboard</h1>
            </div>

            <div class="top-nav-actions">
                <!-- Role Switcher removed as per requirement -->

                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Search...">
                    <i class="fas fa-search search-icon"></i>
                </div>

                <div class="notification-dropdown">
                    <button class="notification-btn" id="notificationBtn">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">5</span>
                    </button>
                    <div class="notification-menu" id="notificationMenu">
                        <div class="notification-header">
                            <h6>Notifications</h6>
                            <a href="#" class="mark-all-read">Mark all as read</a>
                        </div>
                        <div class="notification-list">
                            <div class="notification-item">
                                <div class="notification-icon bg-primary">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-title">New booking received</div>
                                    <div class="notification-time">5 minutes ago</div>
                                </div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-icon bg-success">
                                    <i class="fas fa-sign-in-alt"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-title">Guest checked in - Room 201</div>
                                    <div class="notification-time">15 minutes ago</div>
                                </div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-icon bg-warning">
                                    <i class="fas fa-tools"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-title">Maintenance issue reported - Room 304</div>
                                    <div class="notification-time">30 minutes ago</div>
                                </div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-icon bg-info">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-title">Payment received - Booking #1234</div>
                                    <div class="notification-time">1 hour ago</div>
                                </div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-icon bg-danger">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-title">Low stock alert - POS Inventory</div>
                                    <div class="notification-time">2 hours ago</div>
                                </div>
                            </div>
                        </div>
                        <div class="notification-footer">
                            <a href="#" class="view-all-notifications">View all notifications</a>
                        </div>
                    </div>
                </div>

                <div class="user-dropdown">
                    <button class="user-menu-btn" id="userMenuBtn">
                        <div class="user-avatar small">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <i class="fas fa-chevron-down user-menu-arrow"></i>
                    </button>
                    <div class="user-menu" id="userMenu">
                        <a href="#" class="user-menu-item">
                            <i class="fas fa-user"></i> Profile
                        </a>
                        <a href="#" class="user-menu-item">
                            <i class="fas fa-cog"></i> Settings
                        </a>
                        <a href="#" class="user-menu-item">
                            <i class="fas fa-shield-alt"></i> Security
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="user-menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>