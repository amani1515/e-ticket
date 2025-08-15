<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SyncService;
use App\Models\SyncQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class SyncController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->usertype !== 'admin') {
            return view('errors.403');
        }

        try {
            $syncService = new SyncService();
            $status = $syncService->getSyncStatus();
            
            // Get filter parameters
            $statusFilter = $request->get('status', 'all');
            $dateFilter = $request->get('date', 'all');
            $modelFilter = $request->get('model', 'all');
            $perPage = $request->get('per_page', 20);
            
            // Build query
            $query = SyncQueue::query();
            
            // Status filter
            if ($statusFilter === 'pending') {
                $query->where('synced', false)->where('retry_count', '<', 3);
            } elseif ($statusFilter === 'synced') {
                $query->where('synced', true);
            } elseif ($statusFilter === 'failed') {
                $query->where('synced', false)->where('retry_count', '>=', 3);
            }
            
            // Date filter
            if ($dateFilter === 'today') {
                $query->whereDate('created_at', today());
            } elseif ($dateFilter === 'week') {
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($dateFilter === 'month') {
                $query->whereMonth('created_at', now()->month)
                      ->whereYear('created_at', now()->year);
            }
            
            // Model filter
            if ($modelFilter !== 'all') {
                $query->where('model_type', 'like', '%' . $modelFilter . '%');
            }
            
            // Get paginated results
            $syncData = $query->latest('created_at')
                ->paginate($perPage)
                ->withQueryString();
            
            // Get summary stats
            $summaryStats = [
                'total' => SyncQueue::count(),
                'pending' => SyncQueue::where('synced', false)->where('retry_count', '<', 3)->count(),
                'synced' => SyncQueue::where('synced', true)->count(),
                'failed' => SyncQueue::where('synced', false)->where('retry_count', '>=', 3)->count(),
                'today' => SyncQueue::whereDate('created_at', today())->count(),
                'week' => SyncQueue::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                'month' => SyncQueue::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
            ];
            
            // Get available models
            $availableModels = SyncQueue::select('model_type')
                ->distinct()
                ->pluck('model_type')
                ->map(function($model) {
                    return class_basename($model);
                })
                ->unique()
                ->sort()
                ->values();

            return view('admin.sync.index', compact(
                'status', 'syncData', 'summaryStats', 'availableModels',
                'statusFilter', 'dateFilter', 'modelFilter', 'perPage'
            ));
        } catch (\Exception $e) {
            return view('admin.sync.index', [
                'status' => [
                    'online' => false,
                    'pending' => 0,
                    'failed' => 0,
                    'last_sync' => 'Error: ' . $e->getMessage()
                ],
                'syncData' => collect([])->paginate(20),
                'summaryStats' => ['total' => 0, 'pending' => 0, 'synced' => 0, 'failed' => 0, 'today' => 0, 'week' => 0, 'month' => 0],
                'availableModels' => collect([]),
                'statusFilter' => 'all',
                'dateFilter' => 'all', 
                'modelFilter' => 'all',
                'perPage' => 20
            ]);
        }
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

    public function clearFailed(Request $request)
    {
        if (auth()->user()->usertype !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $deletedCount = SyncQueue::where('synced', false)
                ->where('retry_count', '>=', 3)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => "Cleared {$deletedCount} failed items",
                'deleted' => $deletedCount
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear items: ' . $e->getMessage()
            ], 500);
        }
    }

    public function retryFailed(Request $request)
    {
        if (auth()->user()->usertype !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $updatedCount = SyncQueue::where('synced', false)
                ->where('retry_count', '>=', 3)
                ->update([
                    'retry_count' => 0,
                    'error_message' => null,
                    'last_attempt' => null
                ]);

            return response()->json([
                'success' => true,
                'message' => "Reset {$updatedCount} failed items for retry",
                'updated' => $updatedCount
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retry items: ' . $e->getMessage()
            ], 500);
        }
    }
}