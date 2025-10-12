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
// Add these controllers
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\RoomAssignmentController;
use App\Http\Controllers\WaitingListController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\PromoCodeController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\RoomImageController;
use App\Http\Controllers\InvoiceController;

// Basic Authentication Routes (without email verification)
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes (if needed)
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Test Route - All roles can access
Route::middleware(['auth', 'role:super_admin,property_manager,receptionist,housekeeping,pos_staff,maintenance'])->get('/test-all', function () {
    return "All roles can access this page! Current user: " . auth()->user()->name . " | Role: " . auth()->user()->role->name;
});

// Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
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

// Check-in routes
Route::middleware(['auth', 'role:super_admin,property_manager,receptionist'])->group(function () {
    Route::resource('check-ins', CheckInController::class);
});

// Check-out routes
Route::middleware(['auth', 'role:super_admin,property_manager,receptionist'])->group(function () {
    Route::resource('check-outs', CheckOutController::class);
});

// Room Assignment routes
Route::middleware(['auth', 'role:super_admin,property_manager,receptionist'])->group(function () {
    Route::resource('room-assignments', RoomAssignmentController::class);
});

// Waiting List routes
Route::middleware(['auth', 'role:super_admin,property_manager,receptionist'])->group(function () {
    Route::resource('waiting-list', WaitingListController::class)->names([
        'index' => 'waiting-list.index',
        'create' => 'waiting-list.create',
        'store' => 'waiting-list.store',
        'show' => 'waiting-list.show',
        'edit' => 'waiting-list.edit',
        'update' => 'waiting-list.update',
        'destroy' => 'waiting-list.destroy'
    ]);
});

// Pricing routes
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::resource('prices', PriceController::class);
    Route::post('prices/bulk-store', [PriceController::class, 'bulkStore'])->name('prices.bulk-store');
    Route::resource('seasons', SeasonController::class);
    Route::resource('packages', PackageController::class);
    Route::resource('promo-codes', PromoCodeController::class);
});

// Room Images routes
Route::middleware(['auth', 'role:super_admin,property_manager,receptionist'])->group(function () {
    Route::resource('room-images', RoomImageController::class);
});

// Room Management routes
Route::middleware(['auth', 'role:super_admin,property_manager,receptionist'])->group(function () {
    Route::resource('room-amenities', RoomAmenityController::class);
    Route::resource('room-status-logs', RoomStatusLogController::class);
});

// Booking Management routes
Route::middleware(['auth', 'role:super_admin,property_manager,receptionist'])->group(function () {
    Route::resource('booking-modifications', BookingModificationController::class);
    Route::resource('booking-services', BookingServiceController::class);
    Route::resource('booking-addons', BookingAddonController::class);
});

// Addons & Services routes
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::resource('addons', AddonController::class);
    Route::resource('services', ServiceController::class);
});

// Property Management routes
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::resource('property-amenities', PropertyAmenityController::class);
});

// Guest Management routes
Route::middleware(['auth', 'role:super_admin,property_manager,receptionist'])->group(function () {
    Route::resource('guest-preferences', GuestPreferenceController::class);
});

// Loyalty Programs routes
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::resource('loyalty-programs', LoyaltyProgramController::class);
    Route::resource('loyalty-members', LoyaltyMemberController::class);
    Route::resource('loyalty-points', LoyaltyPointController::class);
});

// Feedback routes
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::resource('feedback', FeedbackController::class);
});

// Maintenance routes
Route::middleware(['auth', 'role:super_admin,property_manager,housekeeping,maintenance'])->group(function () {
    Route::resource('maintenance', MaintenanceController::class);
});

// Housekeeping routes
Route::middleware(['auth', 'role:super_admin,property_manager,housekeeping'])->group(function () {
    Route::resource('housekeeping-staffs', HousekeepingStaffController::class);
    Route::resource('housekeeping-tasks', HousekeepingTaskController::class);
});

// Events routes
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::resource('events', EventController::class);
    Route::get('events-calendar', [EventController::class, 'calendar'])->name('events.calendar');
    Route::get('events/calendar-data', [EventController::class, 'calendarData'])->name('events.calendar-data');
    Route::resource('event-bookings', EventBookingController::class);
    Route::resource('resources', ResourceController::class);
    Route::resource('event-resources', EventResourceController::class);
});

// Treatments & Therapists routes
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::resource('treatments', TreatmentController::class);
    Route::resource('therapists', TherapistController::class);
    Route::resource('appointments', AppointmentController::class);
    Route::get('appointments-calendar', [AppointmentController::class, 'calendar'])->name('appointments.calendar');
    Route::get('appointments/calendar-data', [AppointmentController::class, 'calendarData'])->name('appointments.calendar-data');
});

// Audit Logs routes (Super Admin only)
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::resource('audit-logs', AuditLogController::class)->only(['index', 'show']);
});

// Financial Management routes
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::get('accounts-payable', function () {
        return 'Accounts Payable Page';
    })->name('accounts-payable.index');
    
    Route::get('accounts-receivable', function () {
        return 'Accounts Receivable Page';
    })->name('accounts-receivable.index');
    
    Route::get('expenses', function () {
        return 'Expenses Page';
    })->name('expenses.index');
    
    Route::get('taxes', function () {
        return 'Taxes Page';
    })->name('taxes.index');
    
    // Invoice Routes (existing ones)
    Route::resource('invoices', InvoiceController::class);
    Route::post('invoices/{invoice}/send', [InvoiceController::class, 'send'])->name('invoices.send');
    Route::post('invoices/{invoice}/mark-as-paid', [InvoiceController::class, 'markAsPaid'])->name('invoices.mark-as-paid');
    Route::post('invoices/{invoice}/mark-as-overdue', [InvoiceController::class, 'markAsOverdue'])->name('invoices.mark-as-overdue');
    Route::post('invoices/{invoice}/cancel', [InvoiceController::class, 'cancel'])->name('invoices.cancel');
    Route::get('invoices/{invoice}/generate-pdf', [InvoiceController::class, 'generatePdf'])->name('invoices.generate-pdf');
    Route::post('invoices/{invoice}/send-email', [InvoiceController::class, 'sendEmail'])->name('invoices.send-email');
    Route::get('invoices/{invoice}/download-pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.download-pdf');
    Route::get('invoices/{invoice}/preview-pdf', [InvoiceController::class, 'previewPdf'])->name('invoices.preview-pdf');
    Route::post('invoices/bulk-action', [InvoiceController::class, 'bulkAction'])->name('invoices.bulk-action');
    Route::get('invoices/generate-from-booking/{booking}', [InvoiceController::class, 'generateFromBooking'])->name('invoices.generate-from-booking');
    Route::get('invoices/statistics', [InvoiceController::class, 'statistics'])->name('invoices.statistics');
    Route::get('invoices/check-overdue', [InvoiceController::class, 'checkOverdue'])->name('invoices.check-overdue');
    Route::get('invoices/export-csv', [InvoiceController::class, 'exportCsv'])->name('invoices.export-csv');
    Route::get('invoices/{invoice}/print', [InvoiceController::class, 'printInvoice'])->name('invoices.print');
    Route::get('invoices/{invoice}/duplicate', [InvoiceController::class, 'duplicate'])->name('invoices.duplicate');
    Route::post('invoices/{invoice}/void', [InvoiceController::class, 'void'])->name('invoices.void');
});
// POS & Restaurant Operations routes
Route::middleware(['auth', 'role:super_admin,property_manager,pos_staff'])->group(function () {
    Route::get('pos-outlets', function () {
        return 'POS Outlets Page';
    })->name('pos-outlets.index');
    
    Route::get('pos-categories', function () {
        return 'POS Categories Page';
    })->name('pos-categories.index');
    
    Route::get('pos-products', function () {
        return 'POS Products Page';
    })->name('pos-products.index');
    
    Route::get('pos-orders', function () {
        return 'POS Orders Page';
    })->name('pos-orders.index');
    
    Route::get('pos-payments', function () {
        return 'POS Payments Page';
    })->name('pos-payments.index');
    
    Route::get('pos-inventory', function () {
        return 'POS Inventory Page';
    })->name('pos-inventory.index');
    
    Route::get('menus', function () {
        return 'Menus Page';
    })->name('menus.index');
    
    Route::get('room-service-orders', function () {
        return 'Room Service Orders Page';
    })->name('room-service-orders.index');
});

// Inventory & Procurement routes
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::get('inventory-categories', function () {
        return 'Inventory Categories Page';
    })->name('inventory-categories.index');
    
    Route::get('inventory-items', function () {
        return 'Inventory Items Page';
    })->name('inventory-items.index');
    
    Route::get('inventory-stocks', function () {
        return 'Inventory Stocks Page';
    })->name('inventory-stocks.index');
    
    Route::get('inventory-transactions', function () {
        return 'Inventory Transactions Page';
    })->name('inventory-transactions.index');
    
    Route::get('purchase-orders', function () {
        return 'Purchase Orders Page';
    })->name('purchase-orders.index');
    
    Route::get('suppliers', function () {
        return 'Suppliers Page';
    })->name('suppliers.index');
});

// Channel Management routes
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::get('channels', function () {
        return 'Channels Page';
    })->name('channels.index');
    
    Route::get('channel-properties', function () {
        return 'Channel Properties Page';
    })->name('channel-properties.index');
    
    Route::get('channel-bookings', function () {
        return 'Channel Bookings Page';
    })->name('channel-bookings.index');
    
    Route::get('channel-sync-logs', function () {
        return 'Channel Sync Logs Page';
    })->name('channel-sync-logs.index');
});

// Asset Management routes
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::get('asset-categories', function () {
        return 'Asset Categories Page';
    })->name('asset-categories.index');
    
    Route::get('assets', function () {
        return 'Assets Page';
    })->name('assets.index');
    
    Route::get('asset-maintenance', function () {
        return 'Asset Maintenance Page';
    })->name('asset-maintenance.index');
    
    Route::get('asset-depreciation', function () {
        return 'Asset Depreciation Page';
    })->name('asset-depreciation.index');
});

// Reports & Analytics routes
Route::middleware(['auth', 'role:super_admin,property_manager'])->group(function () {
    Route::get('reports', function () {
        return 'Reports Page';
    })->name('reports.index');
    
    Route::get('scheduled-reports', function () {
        return 'Scheduled Reports Page';
    })->name('scheduled-reports.index');
    
    Route::get('analytics', function () {
        return 'Analytics Page';
    })->name('analytics.index');
    
    Route::get('financial-reports', function () {
        return 'Financial Reports Page';
    })->name('financial-reports.index');
});

// System Administration routes
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('users', function () {
        return 'Users Page';
    })->name('users.index');
    
    Route::get('roles', function () {
        return 'Roles Page';
    })->name('roles.index');
    
    Route::get('languages', function () {
        return 'Languages Page';
    })->name('languages.index');
    
    Route::get('translations', function () {
        return 'Translations Page';
    })->name('translations.index');
    
    Route::get('exchange-rates', function () {
        return 'Exchange Rates Page';
    })->name('exchange-rates.index');
    
    Route::get('email-templates', function () {
        return 'Email Templates Page';
    })->name('email-templates.index');
    
    Route::get('sms-templates', function () {
        return 'SMS Templates Page';
    })->name('sms-templates.index');
    
    Route::get('messages', function () {
        return 'Messages Page';
    })->name('messages.index');
    
    Route::get('notification-logs', function () {
        return 'Notification Logs Page';
    })->name('notification-logs.index');
    
    Route::get('api-keys', function () {
        return 'API Keys Page';
    })->name('api-keys.index');
    
    Route::get('personal-access-tokens', function () {
        return 'Personal Access Tokens Page';
    })->name('personal-access-tokens.index');
});

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Test route
Route::get('/test', function () {
    return "Application is working!";
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');