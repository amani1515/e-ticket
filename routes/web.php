<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\TicketerController;
use App\Http\Controllers\Ticketer\TicketController;
use App\Http\Controllers\Admin\DashboardReportsController;
use App\Http\Controllers\Admin\PassengersReportController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
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
// web.php


Route::get('/admin/passenger-report', [PassengersReportController::class, 'index'])->name('admin.passenger-report');
Route::get('/admin/passenger-report/{id}', [PassengersReportController::class, 'show'])->name('admin.passenger-report.show');
Route::delete('/admin/passenger-report/{id}', [PassengersReportController::class, 'destroy'])->name('admin.passenger-report.destroy');
Route::get('/admin/passenger-report', [PassengersReportController::class, 'index'])->name('admin.passenger-report');


Route::get('/admin', [DashboardReportsController::class, 'index'])->name('admin.index');




Route::get('/admin/passenger-report/export', [PassengersReportController::class, 'export'])
    ->name('admin.passenger.report.export');


    //mahberat
    