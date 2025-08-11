<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SyncService;
use App\Models\SyncQueue;
use Illuminate\Http\Request;

class SyncController extends Controller
{
    public function index()
    {
        if (auth()->user()->usertype !== 'admin') {
            return view('errors.403');
        }

        $syncService = new SyncService();
        $status = $syncService->getSyncStatus();
        
        $recentSync = SyncQueue::with('model')
            ->latest()
            ->limit(20)
            ->get();

        return view('admin.sync.index', compact('status', 'recentSync'));
    }

    public function sync(Request $request)
    {
        if (auth()->user()->usertype !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $syncService = new SyncService();
        $results = $syncService->syncPendingData();

        return response()->json([
            'success' => true,
            'message' => "Sync completed: {$results['success']} successful, {$results['failed']} failed",
            'results' => $results
        ]);
    }

    public function status()
    {
        $syncService = new SyncService();
        return response()->json($syncService->getSyncStatus());
    }
}