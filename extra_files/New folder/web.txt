<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\FloorController;

// Basic Authentication Routes (without email verification)
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes (if needed)
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Role-based routes
    Route::middleware(['role:super_admin'])->group(function () {
        Route::get('/admin/users', function () {
            return 'Admin Users Page';
        });
        
        Route::get('/admin/settings', function () {
            return 'Admin Settings Page';
        });
    });
    
    Route::middleware(['role:property_manager'])->group(function () {
        Route::get('/property/reports', function () {
            return 'Property Reports Page';
        });
    });
    
    Route::middleware(['role:receptionist'])->group(function () {
        Route::get('/reception/bookings', function () {
            return 'Reception Bookings Page';
        });
    });
});

// Currency Routes - Only for Super Admin
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::resource('currencies', CurrencyController::class);
});

// Property routes
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::resource('properties', PropertyController::class);
});

// Floor routes
Route::middleware(['auth', 'role:super_admin,property_manager,receptionist'])->group(function () {
    Route::resource('floors', FloorController::class);
});

// Room Type routes
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::resource('room-types', RoomTypeController::class);
});

// Room routes
Route::middleware(['auth', 'role:super_admin,property_manager,receptionist'])->group(function () {
    Route::resource('rooms', RoomController::class);
    Route::post('rooms/{room}/update-status', [RoomController::class, 'updateStatus'])->name('rooms.update-status');
});

// Guest routes
Route::middleware(['auth', 'role:super_admin,property_manager,receptionist'])->group(function () {
    Route::resource('guests', GuestController::class);
    Route::get('guests/search', [GuestController::class, 'search'])->name('guests.search');
});

// Booking routes
Route::middleware(['auth', 'role:super_admin,property_manager,receptionist'])->group(function () {
    Route::resource('bookings', BookingController::class);
    Route::get('bookings/check-availability', [BookingController::class, 'checkAvailability'])->name('bookings.check-availability');
    Route::get('bookings/calendar', [BookingController::class, 'calendar'])->name('bookings.calendar');
    Route::get('bookings/calendar-data', [BookingController::class, 'calendarData'])->name('bookings.calendar-data');
    Route::post('bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
});

// Payment routes
Route::middleware(['auth', 'role:super_admin,property_manager,receptionist'])->group(function () {
    Route::resource('payments', PaymentController::class);
    Route::post('payments/process', [PaymentController::class, 'processPayment'])->name('payments.process');
    Route::post('payments/{payment}/mark-completed', [PaymentController::class, 'markAsCompleted'])->name('payments.mark-completed');
    Route::post('payments/{payment}/mark-failed', [PaymentController::class, 'markAsFailed'])->name('payments.mark-failed');
    Route::post('payments/{payment}/mark-refunded', [PaymentController::class, 'markAsRefunded'])->name('payments.mark-refunded');
});

// Placeholder routes for sidebar items that don't have controllers yet
Route::middleware(['auth'])->group(function () {
    // Front Desk Operations
    Route::middleware(['role:super_admin,property_manager,receptionist'])->group(function () {
        Route::get('check-ins', function () {
            return 'Check-ins Page - Under Construction';
        })->name('check-ins.index');
        
        Route::get('check-outs', function () {
            return 'Check-outs Page - Under Construction';
        })->name('check-outs.index');
        
        Route::get('room-assignments', function () {
            return 'Room Assignments Page - Under Construction';
        })->name('room-assignments.index');
        
        Route::get('waiting-list', function () {
            return 'Waiting List Page - Under Construction';
        })->name('waiting-list.index');
    });
    
    // Room Management
    Route::middleware(['role:super_admin,property_manager,receptionist'])->group(function () {
        Route::get('amenities', function () {
            return 'Amenities Page - Under Construction';
        })->name('amenities.index');
        
        Route::get('room-images', function () {
            return 'Room Images Page - Under Construction';
        })->name('room-images.index');
    });
    
    // Housekeeping & Maintenance
    Route::middleware(['role:super_admin,property_manager,housekeeping'])->group(function () {
        Route::get('housekeeping-staff', function () {
            return 'Housekeeping Staff Page - Under Construction';
        })->name('housekeeping-staff.index');
        
        Route::get('housekeeping-tasks', function () {
            return 'Housekeeping Tasks Page - Under Construction';
        })->name('housekeeping-tasks.index');
        
        Route::get('maintenance-issues', function () {
            return 'Maintenance Issues Page - Under Construction';
        })->name('maintenance-issues.index');
    });
    
    // Financial Management
    Route::middleware(['role:super_admin,property_manager'])->group(function () {
        Route::get('invoices', function () {
            return 'Invoices Page - Under Construction';
        })->name('invoices.index');
        
        Route::get('accounts-payable', function () {
            return 'Accounts Payable Page - Under Construction';
        })->name('accounts-payable.index');
        
        Route::get('accounts-receivable', function () {
            return 'Accounts Receivable Page - Under Construction';
        })->name('accounts-receivable.index');
        
        Route::get('expenses', function () {
            return 'Expenses Page - Under Construction';
        })->name('expenses.index');
        
        Route::get('taxes', function () {
            return 'Taxes Page - Under Construction';
        })->name('taxes.index');
    });
    
    // POS & Restaurant Operations
    Route::middleware(['role:super_admin,property_manager,pos_staff'])->group(function () {
        Route::get('pos-outlets', function () {
            return 'POS Outlets Page - Under Construction';
        })->name('pos-outlets.index');
        
        Route::get('pos-categories', function () {
            return 'POS Categories Page - Under Construction';
        })->name('pos-categories.index');
        
        Route::get('pos-products', function () {
            return 'POS Products Page - Under Construction';
        })->name('pos-products.index');
        
        Route::get('pos-orders', function () {
            return 'POS Orders Page - Under Construction';
        })->name('pos-orders.index');
        
        Route::get('pos-payments', function () {
            return 'POS Payments Page - Under Construction';
        })->name('pos-payments.index');
        
        Route::get('pos-inventory', function () {
            return 'POS Inventory Page - Under Construction';
        })->name('pos-inventory.index');
        
        Route::get('menus', function () {
            return 'Menus Page - Under Construction';
        })->name('menus.index');
        
        Route::get('room-service-orders', function () {
            return 'Room Service Orders Page - Under Construction';
        })->name('room-service-orders.index');
    });
    
    // Inventory & Procurement
    Route::middleware(['role:super_admin,property_manager'])->group(function () {
        Route::get('inventory-categories', function () {
            return 'Inventory Categories Page - Under Construction';
        })->name('inventory-categories.index');
        
        Route::get('inventory-items', function () {
            return 'Inventory Items Page - Under Construction';
        })->name('inventory-items.index');
        
        Route::get('inventory-stocks', function () {
            return 'Inventory Stocks Page - Under Construction';
        })->name('inventory-stocks.index');
        
        Route::get('inventory-transactions', function () {
            return 'Inventory Transactions Page - Under Construction';
        })->name('inventory-transactions.index');
        
        Route::get('purchase-orders', function () {
            return 'Purchase Orders Page - Under Construction';
        })->name('purchase-orders.index');
        
        Route::get('suppliers', function () {
            return 'Suppliers Page - Under Construction';
        })->name('suppliers.index');
    });
    
    // Guest Relations & Loyalty
    Route::middleware(['role:super_admin,property_manager'])->group(function () {
        Route::get('guest-preferences', function () {
            return 'Guest Preferences Page - Under Construction';
        })->name('guest-preferences.index');
        
        Route::get('loyalty-programs', function () {
            return 'Loyalty Programs Page - Under Construction';
        })->name('loyalty-programs.index');
        
        Route::get('loyalty-members', function () {
            return 'Loyalty Members Page - Under Construction';
        })->name('loyalty-members.index');
        
        Route::get('loyalty-points', function () {
            return 'Loyalty Points Page - Under Construction';
        })->name('loyalty-points.index');
        
        Route::get('feedback', function () {
            return 'Feedback Page - Under Construction';
        })->name('feedback.index');
    });
    
    // Channel Management
    Route::middleware(['role:super_admin,property_manager'])->group(function () {
        Route::get('channels', function () {
            return 'Channels Page - Under Construction';
        })->name('channels.index');
        
        Route::get('channel-properties', function () {
            return 'Channel Properties Page - Under Construction';
        })->name('channel-properties.index');
        
        Route::get('channel-bookings', function () {
            return 'Channel Bookings Page - Under Construction';
        })->name('channel-bookings.index');
        
        Route::get('channel-sync-logs', function () {
            return 'Channel Sync Logs Page - Under Construction';
        })->name('channel-sync-logs.index');
    });
    
    // Events & Appointments
    Route::middleware(['role:super_admin,property_manager'])->group(function () {
        Route::get('events', function () {
            return 'Events Page - Under Construction';
        })->name('events.index');
        
        Route::get('event-bookings', function () {
            return 'Event Bookings Page - Under Construction';
        })->name('event-bookings.index');
        
        Route::get('resources', function () {
            return 'Resources Page - Under Construction';
        })->name('resources.index');
        
        Route::get('treatments', function () {
            return 'Treatments Page - Under Construction';
        })->name('treatments.index');
        
        Route::get('therapists', function () {
            return 'Therapists Page - Under Construction';
        })->name('therapists.index');
        
        Route::get('appointments', function () {
            return 'Appointments Page - Under Construction';
        })->name('appointments.index');
    });
    
    // Asset Management
    Route::middleware(['role:super_admin,property_manager'])->group(function () {
        Route::get('asset-categories', function () {
            return 'Asset Categories Page - Under Construction';
        })->name('asset-categories.index');
        
        Route::get('assets', function () {
            return 'Assets Page - Under Construction';
        })->name('assets.index');
        
        Route::get('asset-maintenance', function () {
            return 'Asset Maintenance Page - Under Construction';
        })->name('asset-maintenance.index');
        
        Route::get('asset-depreciation', function () {
            return 'Asset Depreciation Page - Under Construction';
        })->name('asset-depreciation.index');
    });
    
    // Reports & Analytics
    Route::middleware(['role:super_admin,property_manager'])->group(function () {
        Route::get('reports', function () {
            return 'Reports Page - Under Construction';
        })->name('reports.index');
        
        Route::get('scheduled-reports', function () {
            return 'Scheduled Reports Page - Under Construction';
        })->name('scheduled-reports.index');
        
        Route::get('analytics', function () {
            return 'Analytics Page - Under Construction';
        })->name('analytics.index');
        
        Route::get('financial-reports', function () {
            return 'Financial Reports Page - Under Construction';
        })->name('financial-reports.index');
    });
    
    // System Administration
    Route::middleware(['role:super_admin'])->group(function () {
        Route::get('users', function () {
            return 'Users Page - Under Construction';
        })->name('users.index');
        
        Route::get('roles', function () {
            return 'Roles Page - Under Construction';
        })->name('roles.index');
        
        Route::get('languages', function () {
            return 'Languages Page - Under Construction';
        })->name('languages.index');
        
        Route::get('translations', function () {
            return 'Translations Page - Under Construction';
        })->name('translations.index');
        
        Route::get('exchange-rates', function () {
            return 'Exchange Rates Page - Under Construction';
        })->name('exchange-rates.index');
        
        Route::get('email-templates', function () {
            return 'Email Templates Page - Under Construction';
        })->name('email-templates.index');
        
        Route::get('sms-templates', function () {
            return 'SMS Templates Page - Under Construction';
        })->name('sms-templates.index');
        
        Route::get('messages', function () {
            return 'Messages Page - Under Construction';
        })->name('messages.index');
        
        Route::get('notification-logs', function () {
            return 'Notification Logs Page - Under Construction';
        })->name('notification-logs.index');
        
        Route::get('api-keys', function () {
            return 'API Keys Page - Under Construction';
        })->name('api-keys.index');
        
        Route::get('personal-access-tokens', function () {
            return 'Personal Access Tokens Page - Under Construction';
        })->name('personal-access-tokens.index');
        
        Route::get('audit-logs', function () {
            return 'Audit Logs Page - Under Construction';
        })->name('audit-logs.index');
    });
});

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Test route
Route::get('/test', function () {
    return "Application is working!";
});