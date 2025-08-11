<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SyncApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Ping endpoint to check if server is online
Route::get('/ping', function () {
    return response()->json(['status' => 'online', 'timestamp' => now()]);
});

// Sync API endpoints (protected with API token)
Route::middleware('auth.api.token')->prefix('sync')->group(function () {
    Route::post('/user', [SyncApiController::class, 'syncUser']);
    Route::post('/ticket', [SyncApiController::class, 'syncTicket']);
    Route::post('/schedule', [SyncApiController::class, 'syncSchedule']);
    Route::post('/bus', [SyncApiController::class, 'syncBus']);
    Route::post('/cash_report', [SyncApiController::class, 'syncCashReport']);
    Route::post('/destination', [SyncApiController::class, 'syncDestination']);
    Route::post('/mahberat', [SyncApiController::class, 'syncMahberat']);
    Route::post('/cargo', [SyncApiController::class, 'syncCargo']);
    
    // Batch sync endpoint
    Route::post('/batch', [SyncApiController::class, 'syncBatch']);
});