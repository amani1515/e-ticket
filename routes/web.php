<?php

use App\Http\Controllers\Admin\AdminCashReportController;
use Illuminate\Support\Facades\Route;
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



Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return redirect('/home');
    })->name('dashboard');

   
});


route::get('/home', [AdminController::class, 'index']);

Route::view('/admin', 'admin.index')->name('admin.index');
Route::get('/admin', [DashboardReportsController::class, 'index'])->name('admin.index');


// admin routes for user function
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
});
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('admin.users.show');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});
// Admin destination routes

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('destinations', DestinationController::class);
});




Route::get('/tickets/report', [TicketController::class, 'report'])->name('ticketer.tickets.report')->middleware('auth');

Route::get('/ticketer/tickets/report', [TicketController::class, 'report'])->name('ticketer.tickets.report');
Route::get('/ticketer/tickets/create', [TicketController::class, 'create'])->name('ticketer.tickets.create');
Route::post('/ticketer/tickets/store', [TicketController::class, 'store'])->name('ticketer.tickets.store');
Route::get('/ticketer/tickets/receipt/{ticketId}', [TicketController::class, 'showReceipt'])->name('ticketer.tickets.receipt');
Route::get('/ticketer/tickets/scan', [TicketController::class, 'scan'])->name('ticketer.tickets.scan');
Route::get('/ticketer/tickets/{id}/receipt', [TicketController::class, 'receipt'])->name('ticketer.tickets.receipt');
Route::get('/ticketer/scan', [TicketController::class, 'showScanForm'])->name('ticketer.tickets.scan');
Route::post('/ticketer/scan', [TicketController::class, 'processScan'])->name('ticketer.tickets.processScan');
Route::get('/ticketer/first-queued-bus/{destination}', [App\Http\Controllers\Ticketer\TicketController::class, 'firstQueuedBus']);
Route::post('/ticketer/increment-boarding/{destinationId}', [App\Http\Controllers\Ticketer\TicketController::class, 'incrementBoardingForFirstQueuedBus']); // web.php
Route::get('/ticketer/schedule-report', [\App\Http\Controllers\Ticketer\ScheduleController::class, 'report'])->name('ticketer.schedule.report');
Route::post('/ticketer/schedule/{schedule}/pay', [\App\Http\Controllers\Ticketer\ScheduleController::class, 'pay'])->name('ticketer.schedule.pay');


Route::get('/admin/passenger-report', [PassengersReportController::class, 'index'])->name('admin.passenger-report');
Route::get('/admin/passenger-report/{id}', [PassengersReportController::class, 'show'])->name('admin.passenger-report.show');
Route::delete('/admin/passenger-report/{id}', [PassengersReportController::class, 'destroy'])->name('admin.passenger-report.destroy');
Route::get('/admin/passenger-report', [PassengersReportController::class, 'index'])->name('admin.passenger-report');


Route::get('/admin', [DashboardReportsController::class, 'index'])->name('admin.index');




Route::get('/admin/passenger-report/export', [PassengersReportController::class, 'export'])
    ->name('admin.passenger.report.export');


//mahberat
Route::middleware(['auth', 'verified'])->prefix('mahberat')->name('mahberat.')->group(function () {
    Route::get('/bus/create', [App\Http\Controllers\Mahberat\BusController::class, 'create'])->name('bus.create');
    Route::post('/bus/store', [App\Http\Controllers\Mahberat\BusController::class, 'store'])->name('bus.store');
});
Route::middleware(['auth', 'verified'])->prefix('mahberat')->name('mahberat.')->group(function () {
    Route::get('/buses', [App\Http\Controllers\Mahberat\BusController::class, 'index'])->name('bus.index');
    Route::get('/bus/{bus}/edit', [App\Http\Controllers\Mahberat\BusController::class, 'edit'])->name('bus.edit');
    Route::put('/bus/{bus}', [App\Http\Controllers\Mahberat\BusController::class, 'update'])->name('bus.update');
    Route::delete('/bus/{bus}', [App\Http\Controllers\Mahberat\BusController::class, 'destroy'])->name('bus.destroy');
});

Route::middleware(['auth'])->prefix('mahberat')->name('mahberat.')->group(function () {
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/schedule/create', [ScheduleController::class, 'create'])->name('schedule.create');
    Route::post('/schedule', [ScheduleController::class, 'store'])->name('schedule.store');
});
Route::get('/mahberat/schedules/card-view', [App\Http\Controllers\Mahberat\ScheduleController::class, 'cardView'])->name('schedules.card-view');
Route::get('/ticketer/get-first-queued-bus/{destination}', [App\Http\Controllers\Ticketer\TicketController::class, 'getFirstQueuedBus']);


Route::get('/ticketer/tickets/report', [TicketController::class, 'reports'])->name('ticketer.tickets.report');

//routes for cash reports
Route::middleware(['auth', 'verified'])->prefix('ticketer')->name('ticketer.')->group(function () {
    Route::get('/cash-report', [App\Http\Controllers\Ticketer\CashReportController::class, 'index'])->name('cash-report.index');
    Route::post('/cash-report/submit', [App\Http\Controllers\Ticketer\CashReportController::class, 'submit'])->name('cash-report.submit');
});


// will be deleted   start here
Route::get('/admin/cash-reports', [AdminCashReportController::class, 'index'])->name('admin.cash.reports');
Route::post('/admin/cash-reports/{id}/mark-received', [AdminCashReportController::class, 'markAsReceived'])->name('admin.cash.reports.receive');


Route::get('/admin/passenger-report/export', [PassengersReportController::class, 'export'])->name('admin.passenger.report.export');


// up to here



// Route for All Buses
Route::get('/admin/buses', [BusController::class, 'index'])->name('admin.buses.index');

// Route for Bus Report
Route::get('/admin/bus-reports', [BusReportController::class, 'index'])->name('admin.bus.reports');

Route::get('/bus-display', [PublicDisplayController::class, 'showAllSchedules']);


//for hisab shum

Route::get('/hisab-shum/paid-reports', [\App\Http\Controllers\HisabShum\PaidReportController::class, 'index'])->name('hisabShum.paidReports');
Route::get('/hisab-shum/schedule/{schedule}/certificate', [\App\Http\Controllers\HisabShum\PaidReportController::class, 'certificate'])->name('hisabShum.certificate');
Route::get('/hisab-shum/all-reports', [\App\Http\Controllers\HisabShum\AllReportController::class, 'index'])->name('hisabShum.allReports');