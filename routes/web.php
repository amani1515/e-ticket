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
    Route::resource('users', UserController::class)->except(['show', 'edit', 'update', 'destroy']);
    Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Destinations
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('destinations', DestinationController::class);
});

// Bus Management
Route::get('/admin/buses', [BusController::class, 'index'])->name('admin.buses.index');
Route::get('/admin/bus-reports', [BusReportController::class, 'index'])->name('admin.bus.reports');
Route::get('/admin/buses/banner/{id}', [BusController::class, 'banner'])->name('admin.buses.banner');

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
    Route::resource('mahberats', MahberatController::class)->only(['index', 'create', 'store']);
});

// Cash Reports
Route::middleware(['prevent.caching'])->group(function () {
    Route::get('/admin/cash-reports', [AdminCashReportController::class, 'index'])->name('admin.cash.reports');
    Route::post('/admin/cash-reports/{id}/mark-received', [AdminCashReportController::class, 'markAsReceived'])->name('admin.cash.reports.receive');
});

// Backup
Route::get('/admin/backup', [BackupController::class, 'backupDownload'])->name('admin.backup');

// Schedule Reports
Route::get('/admin/schedule-reports', [\App\Http\Controllers\Admin\ScheduleReportController::class, 'index'])->name('admin.schedule.reports');
Route::get('/admin/reports/transactions', [TransactionController::class, 'index'])->name('admin.reports.transactions')->middleware('auth');
Route::get('/admin/total-reports', [\App\Http\Controllers\Admin\TotalReportController::class, 'index'])->name('admin.total.reports');

// Cargo Settings
Route::resource('admin/cargo-settings', \App\Http\Controllers\Admin\CargoSettingsController::class)
    ->only(['index', 'edit', 'update'])
    ->names('admin.cargo-settings');
Route::post('/admin/cargo-settings/departure-fee', [\App\Http\Controllers\Admin\CargoSettingsController::class, 'updateDepartureFee'])->name('admin.cargo-settings.departure-fee');

// SMS Templates
Route::middleware(['auth', 'verified', 'prevent.caching'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('sms-template', SmsTemplateController::class);
});

// --------------------
// Ticketer Routes
// --------------------
Route::middleware(['auth', 'verified', 'prevent.caching'])->prefix('ticketer')->name('ticketer.')->group(function () {
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
Route::middleware(['auth', 'verified', 'prevent.caching'])->prefix('mahberat')->name('mahberat.')->group(function () {
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
});
Route::get('/mahberat/schedules/card-view', [\App\Http\Controllers\Mahberat\ScheduleController::class, 'cardView'])->name('schedules.card-view');
Route::delete('/mahberat/schedule/{id}', [ScheduleController::class, 'destroy'])->name('mahberat.schedule.destroy');

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
Route::middleware(['prevent.caching'])->group(function () {
    Route::get('/hisab-shum/pay/{schedule}', [\App\Http\Controllers\HisabShum\PaymentController::class, 'initiate'])->name('hisabShum.pay.schedule');
    Route::get('/hisab-shum/payment/callback', [\App\Http\Controllers\HisabShum\PaymentController::class, 'handleCallback'])->name('hisabShum.payment.callback');
    Route::get('/schedules/{schedule}/pay', [PaidReportController::class, 'showPayForm'])->name('hisabShum.schedule.payForm');
    Route::post('/schedules/{schedule}/pay', [PaidReportController::class, 'pay'])->name('hisabShum.schedule.pay');
    Route::get('/schedules/pay/callback', [PaidReportController::class, 'callback'])->name('hisabShum.schedule.callback');
    Route::get('/hisab-shum/paid-reports', [\App\Http\Controllers\HisabShum\PaidReportController::class, 'index'])->name('hisabShum.paidReports');
    Route::get('/hisab-shum/schedule/{schedule}/certificate', [\App\Http\Controllers\HisabShum\PaidReportController::class, 'certificate'])->name('hisabShum.certificate');
    Route::get('/hisab-shum/all-reports', [\App\Http\Controllers\HisabShum\AllReportController::class, 'index'])->name('hisabShum.allReports');
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
