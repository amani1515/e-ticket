<?php

// web.php - Main Route Definitions for the E-Ticket System
// -------------------------------------------------------
// This file defines all web routes for the application, grouped by feature and user role.
// Categories: Admin, Ticketer, Mahberat, Traffic, CargoMan, HisabShum, Public, Shop, Online Ticket
// Repetitive routes are grouped using route groups, prefixes, and resource controllers where possible.

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminCashReportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\TicketerController;
use App\Http\Controllers\Ticketer\TicketController;
use App\Http\Controllers\Admin\DashboardReportsController;
use App\Http\Controllers\Admin\PassengersReportController;
use App\Http\Controllers\Mahberat\ScheduleController;
use App\Http\Controllers\Admin\PassengerReportController;
use App\Http\Controllers\Ticketer\CashReportController;
use App\Http\Controllers\Admin\BusController;
use App\Http\Controllers\Admin\BusReportController;
use App\Http\Controllers\PublicDisplayController;
use App\Http\Controllers\Traffic\TrafficScheduleController;
// <-- Make sure this is present!
use App\Http\Controllers\Admin\MahberatController;
use App\Http\Controllers\HeadOfficeAdminReadOnlyController;
use App\Http\Controllers\CargoMan\CargoController;

use App\Http\Controllers\HisabShum\PaidReportController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\SmsTemplateController;
use App\Http\Controllers\Balehabt\BusController as BalehabtBusController;

// --------------------
// Public Routes
// --------------------
Route::get('/', function () {
    return view('welcome');
});

// --------------------
// Authenticated Dashboard Redirect
// --------------------
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return redirect('/home');
    })->name('dashboard');
});

// --------------------
// Admin Routes
// --------------------
Route::get('/home', [AdminController::class, 'index']);
Route::get('/admin', [DashboardReportsController::class, 'index'])->name('admin.index');

// User Management
Route::middleware(['auth', 'verified', 'prevent.caching'])->prefix('admin')->name('admin.')->group(function () {

});

// Destinations
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('destinations', DestinationController::class);
});


// Passenger Reports
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('passenger-report', [PassengersReportController::class, 'index'])->name('passenger-report');
    Route::get('passenger-report/export', [PassengersReportController::class, 'export'])->name('passenger.report.export');
    Route::get('passenger-report/{id}', [PassengersReportController::class, 'show'])->name('passenger-report.show');
    Route::delete('passenger-report/{id}', [PassengersReportController::class, 'destroy'])->name('passenger-report.destroy');
    Route::put('passenger-report/{id}/refund', [PassengersReportController::class, 'refund'])->name('passenger-report.refund');
    Route::get('passenger-report/print-all', [PassengerReportController::class, 'printAll'])->name('passenger.report.print-all');
});

// Mahberat Management
Route::middleware(['auth',])->prefix('admin')->name('admin.')->group(function () {
});



// Backup
    // admin-only routes 

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class)->except(['show', 'edit', 'update', 'destroy']);
    Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('backup', [BackupController::class, 'backupDownload'])->name('backup');

// Schedule Reports
Route::get('/schedule-reports', [\App\Http\Controllers\Admin\ScheduleReportController::class, 'index'])->name('schedule.reports');
Route::get('/reports/transactions', [TransactionController::class, 'index'])->name('reports.transactions')->middleware('auth');
Route::get('/total-reports', [\App\Http\Controllers\Admin\TotalReportController::class, 'index'])->name('total.reports');

// Cargo Settings
  Route::resource('cargo-settings', \App\Http\Controllers\Admin\CargoSettingsController::class)
        ->only(['index', 'edit', 'update'])
        ->names('cargo-settings');
Route::post('/cargo-settings/departure-fee', [\App\Http\Controllers\Admin\CargoSettingsController::class, 'updateDepartureFee'])->name('cargo-settings.departure-fee');

// Cash Reports
    Route::middleware(['prevent.caching'])->group(function () {
        Route::get('/cash-reports', [AdminCashReportController::class, 'index'])->name('cash.reports');
        Route::post('/cash-reports/{id}/mark-received', [AdminCashReportController::class, 'markAsReceived'])->name('cash.reports.receive');
    });

    Route::resource('destinations', DestinationController::class);
    Route::resource('mahberats', controller: MahberatController::class)->only(['index', 'create', 'store']);

    // Bus Management
Route::get('/buses', [BusController::class, 'index'])->name('buses.index');
Route::get('/bus-reports', [BusReportController::class, 'index'])->name('bus.reports');
Route::get('/buses/banner/{id}', [BusController::class, 'banner'])->name('buses.banner');
    
// route for sms
Route::resource('sms-template', SmsTemplateController::class);

});




// --------------------
// Ticketer Routes
// --------------------

// Only ticketer users
Route::middleware(['auth', 'role:ticketer'])->prefix('ticketer')->name('ticketer.')->group(function () {
    Route::get('/tickets/report', [TicketController::class, 'report'])->name('tickets.report');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets/store', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/receipt/{ticketId}', [TicketController::class, 'showReceipt'])->name('tickets.receipt');
    Route::get('/tickets/scan', [TicketController::class, 'scan'])->name('tickets.scan');
    Route::get('/tickets/{id}/receipt', [TicketController::class, 'receipt'])->name('tickets.receipt');
    Route::get('/scan', [TicketController::class, 'showScanForm'])->name('tickets.scan');
    Route::post('/scan', [TicketController::class, 'processScan'])->name('tickets.processScan');
    Route::get('/first-queued-bus/{destination}', [TicketController::class, 'firstQueuedBus']);
    Route::post('/increment-boarding/{destinationId}', [TicketController::class, 'incrementBoardingForFirstQueuedBus']);
    Route::get('/schedule-report', [\App\Http\Controllers\Ticketer\ScheduleController::class, 'report'])->name('schedule.report');
    Route::post('/schedule/{schedule}/pay', [\App\Http\Controllers\Ticketer\ScheduleController::class, 'pay'])->name('schedule.pay');
    // Secure cargo info route - use POST with encrypted payload instead of GET with UID in URL
    Route::post('/cargo-info', [TicketController::class, 'cargoInfo'])->name('cargo.info');
    Route::put('/tickets/{id}/update', [TicketController::class, 'update'])->name('tickets.update');
    Route::post('/tickets/{id}/cancel', [TicketController::class, 'cancel'])->name('tickets.cancel');
    Route::get('/tickets/export', [TicketController::class, 'export'])->name('tickets.export');
    // Cash reports
    Route::get('/cash-report', [\App\Http\Controllers\Ticketer\CashReportController::class, 'index'])->name('cash-report.index');
    Route::post('/cash-report/submit', [\App\Http\Controllers\Ticketer\CashReportController::class, 'submit'])->name('cash-report.submit');
});


// --------------------
// Mahberat Routes
// --------------------
Route::middleware(['auth', 'role:mahberat'])->prefix('mahberat')->name('mahberat.')->group(function () {
    Route::get('/buses', [\App\Http\Controllers\Mahberat\BusController::class, 'index'])->name('bus.index');
    Route::get('/bus/create', [\App\Http\Controllers\Mahberat\BusController::class, 'create'])->name('bus.create');
    Route::post('/bus/store', [\App\Http\Controllers\Mahberat\BusController::class, 'store'])->name('bus.store');
    Route::get('/bus/{bus}/edit', [\App\Http\Controllers\Mahberat\BusController::class, 'edit'])->name('bus.edit');
    Route::put('/bus/{bus}', [\App\Http\Controllers\Mahberat\BusController::class, 'update'])->name('bus.update');
    Route::delete('/bus/{bus}', [\App\Http\Controllers\Mahberat\BusController::class, 'destroy'])->name('bus.destroy');
    // Schedule management
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/schedule/create', [ScheduleController::class, 'create'])->name('schedule.create');
    Route::post('/schedule', [ScheduleController::class, 'store'])->name('schedule.store');
        Route::get('/schedules/card-view', [\App\Http\Controllers\Mahberat\ScheduleController::class, 'cardView'])
        ->name('schedules.card-view');

    Route::delete('/schedule/{id}', [\App\Http\Controllers\Mahberat\ScheduleController::class, 'destroy'])

        ->name('schedule.destroy');
        Route::get('/bus/check-targa', [\App\Http\Controllers\Mahberat\BusController::class, 'checkTarga']);
});


// --------------------
// Traffic Routes
// --------------------
Route::post('/traffic/schedule-scan', [TrafficScheduleController::class, 'scan'])->name('traffic.schedule.scan');
Route::post('/traffic/schedule/{schedule}/wellgo', [TrafficScheduleController::class, 'markWellgo'])->name('traffic.wellgo');
Route::get('/traffic/schedule-scan', function () {
    return view('traffic.schedule.result');
})->name('traffic.schedule.scan.form');

// --------------------
// HisabShum Routes
// --------------------

Route::middleware(['auth', 'role:hisabshum'])->prefix('hisabshum')->name('hisabshum.')->group(function () {
      Route::get('/hisab-shum/pay/{schedule}', [\App\Http\Controllers\HisabShum\PaymentController::class, 'initiate'])->name('pay.schedule');
    Route::get('/hisab-shum/payment/callback', [\App\Http\Controllers\HisabShum\PaymentController::class, 'handleCallback'])->name('payment.callback');
    Route::get('/schedules/{schedule}/pay', [PaidReportController::class, 'showPayForm'])->name('schedule.payForm');
    Route::post('/schedules/{schedule}/pay', [PaidReportController::class, 'pay'])->name('schedule.pay');
    Route::post('/hisabShum/schedule/{id}/pay-cash', [\App\Http\Controllers\HisabShum\PaidReportController::class, 'payWithCash'])->name('schedule.payCash');
    Route::get('/schedules/pay/callback', [PaidReportController::class, 'callback'])->name('schedule.callback');
    Route::get('/hisab-shum/paid-reports', [\App\Http\Controllers\HisabShum\PaidReportController::class, 'index'])->name('paidReports');
    Route::get('/hisab-shum/schedule/{schedule}/certificate', [\App\Http\Controllers\HisabShum\PaidReportController::class, 'certificate'])->name('certificate');
    Route::get('/hisab-shum/all-reports', [\App\Http\Controllers\HisabShum\AllReportController::class, 'index'])->name('allReports');

});


// --------------------
// Balehabt Routes
// --------------------
Route::middleware(['auth', 'verified', 'prevent.caching'])->prefix('balehabt')->name('balehabt.')->group(function () {
    Route::get('/', [BalehabtBusController::class, 'index'])->name('index');
    Route::get('/overall-bus-report', [BalehabtBusController::class, 'overallBusReport'])->name('overallBusReport');
});

// --------------------
// CargoMan Routes
// --------------------
Route::middleware(['prevent.caching'])->prefix('cargoman')->name('cargoMan.')->group(function () {
    Route::get('/', [\App\Http\Controllers\CargoMan\HomeController::class, 'index'])->name('home');
    Route::get('/cargo/create', [\App\Http\Controllers\CargoMan\CargoController::class, 'create'])->name('cargo.create');
    Route::post('/cargo', [\App\Http\Controllers\CargoMan\CargoController::class, 'store'])->name('cargo.store');
    Route::get('/cargo', [\App\Http\Controllers\CargoMan\CargoController::class, 'index'])->name('cargo.index');
    Route::get('/first-queued-schedule/{destination}', [\App\Http\Controllers\CargoMan\CargoController::class, 'firstQueuedSchedule']);
    Route::get('/cargo/{id}/receipt', [\App\Http\Controllers\CargoMan\CargoController::class, 'receipt'])->name('cargo.receipt');
    Route::get('/available-schedules/{destination}', [\App\Http\Controllers\CargoMan\CargoController::class, 'availableSchedules']);
});

// --------------------
// Public Display & Shop
// --------------------
Route::get('/bus-display', [PublicDisplayController::class, 'showAllSchedules']);
Route::get('/shop', [\App\Http\Controllers\Shop\ShopController::class, 'index']);
Route::post('/shop/tickets', [\App\Http\Controllers\Shop\ShopController::class, 'store'])->name('shop.tickets.store');
Route::get('/shop/tickets/success', [\App\Http\Controllers\Shop\ShopController::class, 'success'])->name('shop.tickets.success');
Route::get('/shop/tickets/cancel', [\App\Http\Controllers\Shop\ShopController::class, 'cancel'])->name('shop.tickets.cancel');

// --------------------
// Online Ticket
// --------------------
use App\Http\Controllers\OnlineTicketController;
Route::get('/online-ticket/create', [OnlineTicketController::class, 'create'])->name('online-ticket.create');
Route::get('/online-ticket', [OnlineTicketController::class, 'index'])->name('online-ticket.index');
Route::get('/online-ticket/search', [OnlineTicketController::class, 'search'])->name('online-ticket.search');
