<nav class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo-container">
            <i class="fas fa-hotel logo-icon"></i>
            <span class="logo-text">Hotel Manager</span>
        </div>
    </div>

    <div class="sidebar-content">
        <!-- Front Desk Operations -->
        <div class="sidebar-section" id="front-desk" data-role="super_admin,property_manager,receptionist">
            <div class="section-header" data-bs-toggle="collapse" data-bs-target="#frontDeskCollapse">
                <i class="fas fa-calendar-check section-icon"></i>
                <span class="section-title">Front Desk Operations</span>
                <i class="fas fa-chevron-down section-arrow"></i>
            </div>
            <div class="collapse show" id="frontDeskCollapse">
                <ul class="subsection-list">
                    <li>
                        <a href="{{ route('bookings.index') }}" class="subsection-link" data-bs-toggle="collapse" data-bs-target="#bookingsSubmenu">
                            <i class="fas fa-calendar-alt"></i> Bookings
                            <i class="fas fa-chevron-right float-end"></i>
                        </a>
                        <ul class="collapse sub-submenu" id="bookingsSubmenu">
                            <li><a href="{{ route('bookings.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-list"></i> All Bookings</a></li>
                            <li><a href="{{ route('booking-addons.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-plus"></i> Booking Add-ons</a></li>
                            <li><a href="{{ route('booking-modifications.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-edit"></i> Booking Modifications</a></li>
                            <li><a href="{{ route('booking-services.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-concierge-bell"></i> Booking Services</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('guests.index') }}" class="subsection-link" data-bs-toggle="collapse" data-bs-target="#guestsSubmenu">
                            <i class="fas fa-users"></i> Guests
                            <i class="fas fa-chevron-right float-end"></i>
                        </a>
                        <ul class="collapse sub-submenu" id="guestsSubmenu">
                            <li><a href="{{ route('guests.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-user-friends"></i> All Guests</a></li>
                            <li><a href="{{ route('guest-preferences.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-heart"></i> Guest Preferences</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('check-ins.index') }}" class="subsection-link"><i class="fas fa-sign-in-alt"></i> Check-ins</a></li>
                    <li><a href="{{ route('check-outs.index') }}" class="subsection-link"><i class="fas fa-sign-out-alt"></i> Check-outs</a></li>
                    <li><a href="{{ route('room-assignments.index') }}" class="subsection-link"><i class="fas fa-door-open"></i> Room Assignments</a></li>
                    <li><a href="{{ route('waiting-list.index') }}" class="subsection-link"><i class="fas fa-list"></i> Waiting List</a></li>
                </ul>
            </div>
        </div>

        <!-- Room Management -->
        <div class="sidebar-section" id="room-management" data-role="super_admin,property_manager,receptionist">
            <div class="section-header" data-bs-toggle="collapse" data-bs-target="#roomManagementCollapse">
                <i class="fas fa-bed section-icon"></i>
                <span class="section-title">Room Management</span>
                <i class="fas fa-chevron-down section-arrow"></i>
            </div>
            <div class="collapse" id="roomManagementCollapse">
                <ul class="subsection-list">
                    <li><a href="{{ route('properties.index') }}" class="subsection-link"><i class="fas fa-building"></i> Properties</a></li>
                    <li><a href="{{ route('room-types.index') }}" class="subsection-link"><i class="fas fa-th-large"></i> Room Types</a></li>
                    <li><a href="{{ route('rooms.index') }}" class="subsection-link"><i class="fas fa-door-closed"></i> Rooms</a></li>
                    <li><a href="{{ route('floors.index') }}" class="subsection-link"><i class="fas fa-layer-group"></i> Floors</a></li>
                    <li>
                        <a href="#" class="subsection-link" data-bs-toggle="collapse" data-bs-target="#pricingSubmenu">
                            <i class="fas fa-dollar-sign"></i> Pricing
                            <i class="fas fa-chevron-right float-end"></i>
                        </a>
                        <ul class="collapse sub-submenu" id="pricingSubmenu">
                            <li><a href="{{ route('prices.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-tag"></i> Prices</a></li>
                            <li><a href="{{ route('seasons.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-calendar"></i> Seasons</a></li>
                            <li><a href="{{ route('packages.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-gift"></i> Packages</a></li>
                            <li><a href="{{ route('promo-codes.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-ticket-alt"></i> Promo Codes</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('room-amenities.index') }}" class="subsection-link"><i class="fas fa-concierge-bell"></i> Room Amenities</a></li>
                    <li><a href="{{ route('room-images.index') }}" class="subsection-link"><i class="fas fa-images"></i> Room Images</a></li>
                    <li><a href="{{ route('room-status-logs.index') }}" class="subsection-link"><i class="fas fa-info-circle"></i> Room Status</a></li>
                </ul>
            </div>
        </div>

        <!-- Financial Management -->
        <div class="sidebar-section" id="financial" data-role="super_admin,property_manager">
            <div class="section-header" data-bs-toggle="collapse" data-bs-target="#financialCollapse">
                <i class="fas fa-credit-card section-icon"></i>
                <span class="section-title">Financial Management</span>
                <i class="fas fa-chevron-down section-arrow"></i>
            </div>
            <div class="collapse" id="financialCollapse">
                <ul class="subsection-list">
                    <li><a href="{{ route('payments.index') }}" class="subsection-link"><i class="fas fa-money-bill-wave"></i> Payments</a></li>
                    <li>
                        <a href="{{ route('invoices.index') }}" class="subsection-link" data-bs-toggle="collapse" data-bs-target="#invoicesSubmenu">
                            <i class="fas fa-file-invoice"></i> Invoices
                            <i class="fas fa-chevron-right float-end"></i>
                        </a>
                        <ul class="collapse sub-submenu" id="invoicesSubmenu">
                            <li><a href="{{ route('invoices.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-file-invoice"></i> All Invoices</a></li>
                            <li><a href="{{ route('invoices.create') }}" class="subsection-link sub-submenu-item"><i class="fas fa-plus"></i> Create Invoice</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('accounts-payable.index') }}" class="subsection-link"><i class="fas fa-hand-holding-usd"></i> Accounts Payable</a></li>
                    <li><a href="{{ route('accounts-receivable.index') }}" class="subsection-link"><i class="fas fa-money-check-alt"></i> Accounts Receivable</a></li>
                    <li><a href="{{ route('expenses.index') }}" class="subsection-link"><i class="fas fa-receipt"></i> Expenses</a></li>
                    <li><a href="{{ route('taxes.index') }}" class="subsection-link"><i class="fas fa-percentage"></i> Taxes</a></li>
                </ul>
            </div>
        </div>

        <!-- Housekeeping & Maintenance -->
        <div class="sidebar-section" id="housekeeping" data-role="super_admin,property_manager,housekeeping">
            <div class="section-header" data-bs-toggle="collapse" data-bs-target="#housekeepingCollapse">
                <i class="fas fa-broom section-icon"></i>
                <span class="section-title">Housekeeping & Maintenance</span>
                <i class="fas fa-chevron-down section-arrow"></i>
            </div>
            <div class="collapse" id="housekeepingCollapse">
                <ul class="subsection-list">
                    <li><a href="{{ route('housekeeping-staffs.index') }}" class="subsection-link"><i class="fas fa-user-friends"></i> Housekeeping Staff</a></li>
                    <li><a href="{{ route('housekeeping-tasks.index') }}" class="subsection-link"><i class="fas fa-tasks"></i> Housekeeping Tasks</a></li>
                    <li><a href="{{ route('maintenance.index') }}" class="subsection-link"><i class="fas fa-tools"></i> Maintenance Issues</a></li>
                </ul>
            </div>
        </div>

        <!-- POS & Restaurant Operations -->
        <div class="sidebar-section" id="pos" data-role="super_admin,property_manager,pos_staff">
            <div class="section-header" data-bs-toggle="collapse" data-bs-target="#posCollapse">
                <i class="fas fa-store section-icon"></i>
                <span class="section-title">POS & Restaurant Operations</span>
                <i class="fas fa-chevron-down section-arrow"></i>
            </div>
            <div class="collapse" id="posCollapse">
                <ul class="subsection-list">
                    <li><a href="{{ route('pos-outlets.index') }}" class="subsection-link"><i class="fas fa-store-alt"></i> POS Outlets</a></li>
                    <li><a href="{{ route('pos-categories.index') }}" class="subsection-link"><i class="fas fa-tags"></i> POS Categories</a></li>
                    <li><a href="{{ route('pos-products.index') }}" class="subsection-link"><i class="fas fa-box"></i> POS Products</a></li>
                    <li><a href="{{ route('pos-orders.index') }}" class="subsection-link"><i class="fas fa-shopping-cart"></i> POS Orders</a></li>
                    <li><a href="{{ route('pos-payments.index') }}" class="subsection-link"><i class="fas fa-cash-register"></i> POS Payments</a></li>
                    <li><a href="{{ route('pos-inventory.index') }}" class="subsection-link"><i class="fas fa-warehouse"></i> POS Inventory</a></li>
                    <li><a href="{{ route('menus.index') }}" class="subsection-link"><i class="fas fa-utensils"></i> Menus</a></li>
                    <li><a href="{{ route('room-service-orders.index') }}" class="subsection-link"><i class="fas fa-room-service"></i> Room Service</a></li>
                </ul>
            </div>
        </div>

        <!-- Inventory & Procurement -->
        <div class="sidebar-section" id="inventory" data-role="super_admin,property_manager">
            <div class="section-header" data-bs-toggle="collapse" data-bs-target="#inventoryCollapse">
                <i class="fas fa-boxes section-icon"></i>
                <span class="section-title">Inventory & Procurement</span>
                <i class="fas fa-chevron-down section-arrow"></i>
            </div>
            <div class="collapse" id="inventoryCollapse">
                <ul class="subsection-list">
                    <li><a href="{{ route('inventory-categories.index') }}" class="subsection-link"><i class="fas fa-folder"></i> Inventory Categories</a></li>
                    <li><a href="{{ route('inventory-items.index') }}" class="subsection-link"><i class="fas fa-box-open"></i> Inventory Items</a></li>
                    <li><a href="{{ route('inventory-stocks.index') }}" class="subsection-link"><i class="fas fa-warehouse"></i> Inventory Stocks</a></li>
                    <li><a href="{{ route('inventory-transactions.index') }}" class="subsection-link"><i class="fas fa-exchange-alt"></i> Inventory Transactions</a></li>
                    <li><a href="{{ route('purchase-orders.index') }}" class="subsection-link"><i class="fas fa-file-invoice-dollar"></i> Purchase Orders</a></li>
                    <li><a href="{{ route('suppliers.index') }}" class="subsection-link"><i class="fas fa-truck"></i> Suppliers</a></li>
                </ul>
            </div>
        </div>

        <!-- Guest Relations & Loyalty -->
        <div class="sidebar-section" id="guest-relations" data-role="super_admin,property_manager">
            <div class="section-header" data-bs-toggle="collapse" data-bs-target="#guestRelationsCollapse">
                <i class="fas fa-heart section-icon"></i>
                <span class="section-title">Guest Relations & Loyalty</span>
                <i class="fas fa-chevron-down section-arrow"></i>
            </div>
            <div class="collapse" id="guestRelationsCollapse">
                <ul class="subsection-list">
                    <li><a href="{{ route('guest-preferences.index') }}" class="subsection-link"><i class="fas fa-heart"></i> Guest Preferences</a></li>
                    <li><a href="{{ route('loyalty-programs.index') }}" class="subsection-link"><i class="fas fa-star"></i> Loyalty Programs</a></li>
                    <li><a href="{{ route('loyalty-members.index') }}" class="subsection-link"><i class="fas fa-users-cog"></i> Loyalty Members</a></li>
                    <li><a href="{{ route('loyalty-points.index') }}" class="subsection-link"><i class="fas fa-coins"></i> Loyalty Points</a></li>
                    <li><a href="{{ route('feedback.index') }}" class="subsection-link"><i class="fas fa-comment-alt"></i> Feedback</a></li>
                </ul>
            </div>
        </div>

        <!-- Channel Management -->
        <div class="sidebar-section" id="channel-management" data-role="super_admin,property_manager">
            <div class="section-header" data-bs-toggle="collapse" data-bs-target="#channelCollapse">
                <i class="fas fa-plug section-icon"></i>
                <span class="section-title">Channel Management</span>
                <i class="fas fa-chevron-down section-arrow"></i>
            </div>
            <div class="collapse" id="channelCollapse">
                <ul class="subsection-list">
                    <li><a href="{{ route('channels.index') }}" class="subsection-link"><i class="fas fa-plug"></i> Channels</a></li>
                    <li><a href="{{ route('channel-properties.index') }}" class="subsection-link"><i class="fas fa-link"></i> Channel Properties</a></li>
                    <li><a href="{{ route('channel-bookings.index') }}" class="subsection-link"><i class="fas fa-calendar-alt"></i> Channel Bookings</a></li>
                    <li><a href="{{ route('channel-sync-logs.index') }}" class="subsection-link"><i class="fas fa-sync"></i> Channel Sync Logs</a></li>
                </ul>
            </div>
        </div>

        <!-- Events & Appointments -->
        <div class="sidebar-section" id="events" data-role="super_admin,property_manager">
            <div class="section-header" data-bs-toggle="collapse" data-bs-target="#eventsCollapse">
                <i class="fas fa-calendar-alt section-icon"></i>
                <span class="section-title">Events & Appointments</span>
                <i class="fas fa-chevron-down section-arrow"></i>
            </div>
            <div class="collapse" id="eventsCollapse">
                <ul class="subsection-list">
                    <li><a href="{{ route('events.index') }}" class="subsection-link"><i class="fas fa-calendar-alt"></i> Events</a></li>
                    <li><a href="{{ route('event-bookings.index') }}" class="subsection-link"><i class="fas fa-ticket-alt"></i> Event Bookings</a></li>
                    <li><a href="{{ route('resources.index') }}" class="subsection-link"><i class="fas fa-cubes"></i> Resources</a></li>
                    <li><a href="{{ route('event-resources.index') }}" class="subsection-link"><i class="fas fa-cubes"></i> Event Resources</a></li>
                    <li><a href="{{ route('treatments.index') }}" class="subsection-link"><i class="fas fa-spa"></i> Treatments</a></li>
                    <li><a href="{{ route('therapists.index') }}" class="subsection-link"><i class="fas fa-user-md"></i> Therapists</a></li>
                    <li><a href="{{ route('appointments.index') }}" class="subsection-link"><i class="fas fa-calendar-check"></i> Appointments</a></li>
                </ul>
            </div>
        </div>

        <!-- Asset Management -->
        <div class="sidebar-section" id="asset-management" data-role="super_admin,property_manager">
            <div class="section-header" data-bs-toggle="collapse" data-bs-target="#assetCollapse">
                <i class="fas fa-couch section-icon"></i>
                <span class="section-title">Asset Management</span>
                <i class="fas fa-chevron-down section-arrow"></i>
            </div>
            <div class="collapse" id="assetCollapse">
                <ul class="subsection-list">
                    <li><a href="{{ route('asset-categories.index') }}" class="subsection-link"><i class="fas fa-folder-open"></i> Asset Categories</a></li>
                    <li><a href="{{ route('assets.index') }}" class="subsection-link"><i class="fas fa-couch"></i> Assets</a></li>
                    <li><a href="{{ route('asset-maintenance.index') }}" class="subsection-link"><i class="fas fa-wrench"></i> Asset Maintenance</a></li>
                    <li><a href="{{ route('asset-depreciation.index') }}" class="subsection-link"><i class="fas fa-chart-line"></i> Asset Depreciation</a></li>
                </ul>
            </div>
        </div>

        <!-- Reports & Analytics -->
        <div class="sidebar-section" id="reports" data-role="super_admin,property_manager">
            <div class="section-header" data-bs-toggle="collapse" data-bs-target="#reportsCollapse">
                <i class="fas fa-chart-bar section-icon"></i>
                <span class="section-title">Reports & Analytics</span>
                <i class="fas fa-chevron-down section-arrow"></i>
            </div>
            <div class="collapse" id="reportsCollapse">
                <ul class="subsection-list">
                    <li><a href="{{ route('reports.index') }}" class="subsection-link"><i class="fas fa-file-alt"></i> Reports</a></li>
                    <li><a href="{{ route('scheduled-reports.index') }}" class="subsection-link"><i class="fas fa-clock"></i> Scheduled Reports</a></li>
                    <li><a href="{{ route('analytics.index') }}" class="subsection-link"><i class="fas fa-chart-pie"></i> Analytics</a></li>
                    <li><a href="{{ route('financial-reports.index') }}" class="subsection-link"><i class="fas fa-file-invoice-dollar"></i> Financial Reports</a></li>
                </ul>
            </div>
        </div>

        <!-- System Administration -->
        <div class="sidebar-section" id="system-admin" data-role="super_admin">
            <div class="section-header" data-bs-toggle="collapse" data-bs-target="#systemAdminCollapse">
                <i class="fas fa-cogs section-icon"></i>
                <span class="section-title">System Administration</span>
                <i class="fas fa-chevron-down section-arrow"></i>
            </div>
            <div class="collapse" id="systemAdminCollapse">
                <ul class="subsection-list">
                    <li>
                        <a href="#" class="subsection-link" data-bs-toggle="collapse" data-bs-target="#userManagementSubmenu">
                            <i class="fas fa-users"></i> User Management
                            <i class="fas fa-chevron-right float-end"></i>
                        </a>
                        <ul class="collapse sub-submenu" id="userManagementSubmenu">
                            <li><a href="{{ route('users.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-user"></i> Users</a></li>
                            <li><a href="{{ route('roles.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-user-tag"></i> Roles</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="subsection-link" data-bs-toggle="collapse" data-bs-target="#systemConfigSubmenu">
                            <i class="fas fa-cog"></i> System Configuration
                            <i class="fas fa-chevron-right float-end"></i>
                        </a>
                        <ul class="collapse sub-submenu" id="systemConfigSubmenu">
                            <li><a href="{{ route('languages.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-language"></i> Languages</a></li>
                            <li><a href="{{ route('translations.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-language"></i> Translations</a></li>
                            <li><a href="{{ route('currencies.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-money-bill"></i> Currencies</a></li>
                            <li><a href="{{ route('exchange-rates.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-exchange-alt"></i> Exchange Rates</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="subsection-link" data-bs-toggle="collapse" data-bs-target="#communicationSubmenu">
                            <i class="fas fa-envelope"></i> Communication
                            <i class="fas fa-chevron-right float-end"></i>
                        </a>
                        <ul class="collapse sub-submenu" id="communicationSubmenu">
                            <li><a href="{{ route('email-templates.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-envelope"></i> Email Templates</a></li>
                            <li><a href="{{ route('sms-templates.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-sms"></i> SMS Templates</a></li>
                            <li><a href="{{ route('messages.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-comment"></i> Messages</a></li>
                            <li><a href="{{ route('notification-logs.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-bell"></i> Notification Logs</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="subsection-link" data-bs-toggle="collapse" data-bs-target="#securitySubmenu">
                            <i class="fas fa-shield-alt"></i> Security
                            <i class="fas fa-chevron-right float-end"></i>
                        </a>
                        <ul class="collapse sub-submenu" id="securitySubmenu">
                            <li><a href="{{ route('api-keys.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-key"></i> API Keys</a></li>
                            <li><a href="{{ route('personal-access-tokens.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-key"></i> Personal Access Tokens</a></li>
                            <li><a href="{{ route('audit-logs.index') }}" class="subsection-link sub-submenu-item"><i class="fas fa-history"></i> Audit Logs</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="sidebar-footer">
        <div class="user-profile">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">{{ auth()->user()->role->name }}</div>
            </div>
        </div>
        <a href="{{ route('logout') }}" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</nav>