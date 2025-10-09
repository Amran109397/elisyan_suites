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
// New Controllers
use App\Http\Controllers\RoomAmenityController;
use App\Http\Controllers\RoomStatusLogController;
use App\Http\Controllers\BookingModificationController;
use App\Http\Controllers\BookingServiceController;
use App\Http\Controllers\BookingAddonController;
use App\Http\Controllers\AddonController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PropertyAmenityController;
use App\Http\Controllers\GuestPreferenceController;
use App\Http\Controllers\LoyaltyProgramController;
use App\Http\Controllers\LoyaltyMemberController;
use App\Http\Controllers\LoyaltyPointController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\HousekeepingStaffController;
use App\Http\Controllers\HousekeepingTaskController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventBookingController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\EventResourceController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\TherapistController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuditLogController;
// Additional Controllers
use App\Http\Controllers\PriceController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PromoCodeController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\UserPropertyController;
use App\Http\Controllers\WaitingListController;
use App\Http\Controllers\RoomImageController;

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

// Price Management Routes
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::resource('prices', PriceController::class);
});

// Package Management Routes
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::resource('packages', PackageController::class);
});

// Promo Code Management Routes - Updated to match sidebar
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::resource('promo-codes', PromoCodeController::class);
});

// Season Management Routes
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::resource('seasons', SeasonController::class);
});

// User Property Assignment Routes
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::resource('user-properties', UserPropertyController::class);
});

// Waiting List Routes - Updated to match sidebar
Route::middleware(['auth', 'role:super_admin,property_manager,receptionist'])->group(function () {
    Route::resource('waiting-list', WaitingListController::class);
});

// New Routes - Room Management
Route::middleware(['auth', 'role:super_admin,property_manager,receptionist'])->group(function () {
    Route::resource('room-amenities', RoomAmenityController::class);
    Route::resource('room-status-logs', RoomStatusLogController::class);
    Route::resource('room-images', RoomImageController::class);
});

// New Routes - Booking Management
Route::middleware(['auth', 'role:super_admin,property_manager,receptionist'])->group(function () {
    Route::resource('booking-modifications', BookingModificationController::class);
    Route::resource('booking-services', BookingServiceController::class);
    Route::resource('booking-addons', BookingAddonController::class);
});

// New Routes - Addons & Services
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::resource('addons', AddonController::class);
    Route::resource('services', ServiceController::class);
});

// New Routes - Property Management
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::resource('property-amenities', PropertyAmenityController::class);
});

// New Routes - Guest Management
Route::middleware(['auth', 'role:super_admin,property_manager,receptionist'])->group(function () {
    Route::resource('guest-preferences', GuestPreferenceController::class);
});

// New Routes - Loyalty Programs
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::resource('loyalty-programs', LoyaltyProgramController::class);
    Route::resource('loyalty-members', LoyaltyMemberController::class);
    Route::resource('loyalty-points', LoyaltyPointController::class);
});

// New Routes - Feedback
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::resource('feedback', FeedbackController::class);
});

// New Routes - Maintenance - Updated to match sidebar
Route::middleware(['auth', 'role:super_admin,property_manager,housekeeping'])->group(function () {
    Route::resource('maintenance-issues', MaintenanceController::class);
});

// New Routes - Housekeeping
Route::middleware(['auth', 'role:super_admin,property_manager,housekeeping'])->group(function () {
    Route::resource('housekeeping-staffs', HousekeepingStaffController::class);
    Route::resource('housekeeping-tasks', HousekeepingTaskController::class);
    
    // Additional Housekeeping Task Routes
    Route::post('housekeeping-tasks/{task}/start', [HousekeepingTaskController::class, 'start'])->name('housekeeping-tasks.start');
    Route::post('housekeeping-tasks/{task}/complete', [HousekeepingTaskController::class, 'complete'])->name('housekeeping-tasks.complete');
    Route::post('housekeeping-tasks/{task}/cancel', [HousekeepingTaskController::class, 'cancel'])->name('housekeeping-tasks.cancel');
});

// New Routes - Events
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::resource('events', EventController::class);
    Route::get('events/calendar-data', [EventController::class, 'calendarData'])->name('events.calendar-data');
    
    // Event Status Routes
    Route::post('events/{event}/publish', [EventController::class, 'publish'])->name('events.publish');
    Route::post('events/{event}/start', [EventController::class, 'start'])->name('events.start');
    Route::post('events/{event}/complete', [EventController::class, 'complete'])->name('events.complete');
    Route::post('events/{event}/cancel', [EventController::class, 'cancel'])->name('events.cancel');
});

// New Routes - Event Bookings
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::resource('event-bookings', EventBookingController::class);
    
    // Event Booking Status Routes
    Route::post('event-bookings/{booking}/confirm', [EventBookingController::class, 'confirm'])->name('event-bookings.confirm');
    Route::post('event-bookings/{booking}/cancel', [EventBookingController::class, 'cancel'])->name('event-bookings.cancel');
});

// New Routes - Resources
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::resource('resources', ResourceController::class);
});

// New Routes - Event Resources
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::resource('event-resources', EventResourceController::class);
});

// New Routes - Treatments & Therapists
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::resource('treatments', TreatmentController::class);
    Route::resource('therapists', TherapistController::class);
    Route::resource('appointments', AppointmentController::class);
    
    // Appointment Routes
    Route::get('appointments/calendar-data', [AppointmentController::class, 'calendarData'])->name('appointments.calendar-data');
    Route::post('appointments/{appointment}/confirm', [AppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::post('appointments/{appointment}/start', [AppointmentController::class, 'start'])->name('appointments.start');
    Route::post('appointments/{appointment}/complete', [AppointmentController::class, 'complete'])->name('appointments.complete');
    Route::post('appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
});

// New Routes - Audit Logs (Super Admin only)
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::resource('audit-logs', AuditLogController::class)->only(['index', 'show']);
    Route::get('audit-logs/export', [AuditLogController::class, 'export'])->name('audit-logs.export');
});

// API Routes for dynamic data
Route::middleware(['auth'])->group(function () {
    // Room Types by Property
    Route::get('/api/room-types/by-property/{propertyId}', function($propertyId) {
        return App\Models\RoomType::where('property_id', $propertyId)->get();
    });
    
    // Rooms by Property and Room Type
    Route::get('/api/rooms/by-property-type', function(Request $request) {
        $propertyId = $request->input('property_id');
        $roomTypeId = $request->input('room_type_id');
        $checkInDate = $request->input('check_in_date');
        $checkOutDate = $request->input('check_out_date');
        
        $query = App\Models\Room::where('property_id', $propertyId)
            ->where('room_type_id', $roomTypeId)
            ->where('status', 'available');
            
        // Check availability for the given dates
        if ($checkInDate && $checkOutDate) {
            $bookedRooms = App\Models\Booking::where('property_id', $propertyId)
                ->where(function($query) use ($checkInDate, $checkOutDate) {
                    $query->where(function($q) use ($checkInDate, $checkOutDate) {
                        $q->where('check_in_date', '<=', $checkOutDate)
                            ->where('check_out_date', '>=', $checkInDate);
                    });
                })
                ->whereNotIn('status', ['cancelled', 'no_show'])
                ->pluck('room_id');
                
            $query->whereNotIn('id', $bookedRooms);
        }
        
        return $query->get();
    });
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
    });
    
    // Room Management
    Route::middleware(['role:super_admin,property_manager,receptionist'])->group(function () {
        Route::get('amenities', function () {
            return 'Amenities Page - Under Construction';
        })->name('amenities.index');
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