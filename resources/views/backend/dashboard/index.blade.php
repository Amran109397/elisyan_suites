@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Welcome Message -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="welcome-message">Welcome to Hotel Management System</h2>
        </div>
    </div>

    <!-- Role-specific Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="quick-actions">
                        <!-- Super Admin Actions -->
                        <div class="quick-action" data-role="super_admin">
                            <button class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Property
                            </button>
                        </div>
                        <div class="quick-action" data-role="super_admin">
                            <button class="btn btn-info">
                                <i class="fas fa-user-plus"></i> Add User
                            </button>
                        </div>

                        <!-- Receptionist Actions -->
                        <div class="quick-action" data-role="receptionist">
                            <button class="btn btn-success">
                                <i class="fas fa-calendar-plus"></i> New Booking
                            </button>
                        </div>
                        <div class="quick-action" data-role="receptionist">
                            <button class="btn btn-primary">
                                <i class="fas fa-sign-in-alt"></i> Check-in Guest
                            </button>
                        </div>

                        <!-- Housekeeping Actions -->
                        <div class="quick-action" data-role="housekeeping">
                            <button class="btn btn-warning">
                                <i class="fas fa-tasks"></i> Assign Task
                            </button>
                        </div>
                        <div class="quick-action" data-role="housekeeping">
                            <button class="btn btn-success">
                                <i class="fas fa-check"></i> Mark Complete
                            </button>
                        </div>

                        <!-- POS Staff Actions -->
                        <div class="quick-action" data-role="pos_staff">
                            <button class="btn btn-primary">
                                <i class="fas fa-plus"></i> New Order
                            </button>
                        </div>
                        <div class="quick-action" data-role="pos_staff">
                            <button class="btn btn-success">
                                <i class="fas fa-cash-register"></i> Process Payment
                            </button>
                        </div>

                        <!-- Maintenance Actions -->
                        <div class="quick-action" data-role="maintenance">
                            <button class="btn btn-danger">
                                <i class="fas fa-plus"></i> Report Issue
                            </button>
                        </div>
                        <div class="quick-action" data-role="maintenance">
                            <button class="btn btn-warning">
                                <i class="fas fa-wrench"></i> Update Status
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-container">
        <div class="row">
            @foreach($stats as $stat)
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card {{ $stat['color'] }}">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="{{ $stat['icon'] }}"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">{{ $stat['value'] }}</div>
                            <div class="stat-label">{{ $stat['label'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Charts and Activity -->
    <div class="row">
        <!-- Revenue Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Revenue Overview</h5>
                    <div class="card-actions">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Last 7 Days
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                                <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                                <li><a class="dropdown-item" href="#">Last 90 Days</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Feed -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <div class="activity-feed">
                        @foreach($activities as $activity)
                        <div class="activity-item">
                            <div class="activity-icon bg-{{ $activity['color'] }}">
                                <i class="{{ $activity['icon'] }}"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">{{ $activity['title'] }}</div>
                                <div class="activity-time">{{ $activity['time'] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Module Overview -->
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">System Modules</h4>
        </div>

        <!-- Front Desk Module -->
        <div class="col-lg-3 col-md-6 mb-4" data-role="super_admin,property_manager,receptionist">
            <div class="module-card">
                <div class="module-card-body">
                    <div class="module-icon primary">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h5 class="module-title">Front Desk</h5>
                    <p class="module-description">Manage bookings, guests, check-ins, and room assignments</p>
                    <div class="module-stats">
                        <div class="module-stat">
                            <div class="module-stat-value">128</div>
                            <div class="module-stat-label">Bookings</div>
                        </div>
                        <div class="module-stat">
                            <div class="module-stat-value">24</div>
                            <div class="module-stat-label">Check-ins</div>
                        </div>
                        <div class="module-stat">
                            <div class="module-stat-value">5</div>
                            <div class="module-stat-label">Pending</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Room Management Module -->
        <div class="col-lg-3 col-md-6 mb-4" data-role="super_admin,property_manager,receptionist">
            <div class="module-card">
                <div class="module-card-body">
                    <div class="module-icon success">
                        <i class="fas fa-bed"></i>
                    </div>
                    <h5 class="module-title">Room Management</h5>
                    <p class="module-description">Manage properties, room types, and room status</p>
                    <div class="module-stats">
                        <div class="module-stat">
                            <div class="module-stat-value">145</div>
                            <div class="module-stat-label">Rooms</div>
                        </div>
                        <div class="module-stat">
                            <div class="module-stat-value">12</div>
                            <div class="module-stat-label">Types</div>
                        </div>
                        <div class="module-stat">
                            <div class="module-stat-value">3</div>
                            <div class="module-stat-label">Properties</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Module -->
        <div class="col-lg-3 col-md-6 mb-4" data-role="super_admin,property_manager">
            <div class="module-card">
                <div class="module-card-body">
                    <div class="module-icon info">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h5 class="module-title">Financial</h5>
                    <p class="module-description">Manage payments, invoices, and financial reports</p>
                    <div class="module-stats">
                        <div class="module-stat">
                            <div class="module-stat-value">$45K</div>
                            <div class="module-stat-label">Revenue</div>
                        </div>
                        <div class="module-stat">
                            <div class="module-stat-value">324</div>
                            <div class="module-stat-label">Payments</div>
                        </div>
                        <div class="module-stat">
                            <div class="module-stat-value">12</div>
                            <div class="module-stat-label">Pending</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Housekeeping Module -->
        <div class="col-lg-3 col-md-6 mb-4" data-role="super_admin,property_manager,housekeeping">
            <div class="module-card">
                <div class="module-card-body">
                    <div class="module-icon warning">
                        <i class="fas fa-broom"></i>
                    </div>
                    <h5 class="module-title">Housekeeping</h5>
                    <p class="module-description">Manage cleaning tasks and maintenance issues</p>
                    <div class="module-stats">
                        <div class="module-stat">
                            <div class="module-stat-value">24</div>
                            <div class="module-stat-label">Tasks</div>
                        </div>
                        <div class="module-stat">
                            <div class="module-stat-value">8</div>
                            <div class="module-stat-label">In Progress</div>
                        </div>
                        <div class="module-stat">
                            <div class="module-stat-value">3</div>
                            <div class="module-stat-label">Urgent</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection