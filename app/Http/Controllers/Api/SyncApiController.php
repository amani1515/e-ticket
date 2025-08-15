<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Schedule;
use App\Models\Bus;
use App\Models\CashReport;
use App\Models\Destination;
use App\Models\Mahberat;
use App\Models\Cargo;
use Illuminate\Support\Facades\DB;
use Exception;

class SyncApiController extends Controller
{
    public function syncUser(Request $request)
    {
        return $this->syncModel(User::class, $request);
    }

    public function syncTicket(Request $request)
    {
        return $this->syncModel(Ticket::class, $request);
    }

    public function syncSchedule(Request $request)
    {
        return $this->syncModel(Schedule::class, $request);
    }

    public function syncBus(Request $request)
    {
        return $this->syncModel(Bus::class, $request);
    }

    public function syncCashReport(Request $request)
    {
        return $this->syncModel(CashReport::class, $request);
    }

    public function syncDestination(Request $request)
    {
        return $this->syncModel(Destination::class, $request);
    }

    public function syncMahberat(Request $request)
    {
        return $this->syncModel(Mahberat::class, $request);
    }

    public function syncCargo(Request $request)
    {
        return $this->syncModel(Cargo::class, $request);
    }

    private function syncModel(string $modelClass, Request $request)
    {
        try {
            $uuid = $request->input('uuid');
            $action = $request->input('action');
            $data = $request->input('data');

            if (!$uuid || !$action || !$data) {
                return response()->json(['error' => 'Missing required fields'], 400);
            }

            DB::beginTransaction();

            switch ($action) {
                case 'create':
                    $this->handleCreate($modelClass, $uuid, $data);
                    break;
                case 'update':
                    $this->handleUpdate($modelClass, $uuid, $data);
                    break;
                case 'delete':
                    $this->handleDelete($modelClass, $uuid);
                    break;
                default:
                    return response()->json(['error' => 'Invalid action'], 400);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data synced successfully',
                'uuid' => $uuid,
                'action' => $action
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Sync failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function handleCreate(string $modelClass, string $uuid, array $data)
    {
        // Check if record already exists
        $existing = $modelClass::where('uuid', $uuid)->first();
        if ($existing) {
            // Update if remote is newer or force update
            $existing->update($data);
            return;
        }

        // Create new record
        try {
            $modelClass::create($data);
        } catch (\Exception $e) {
            // If creation fails, try to find by other unique fields and update
            if (strpos($modelClass, 'User') !== false && isset($data['email'])) {
                $existing = $modelClass::where('email', $data['email'])->first();
                if ($existing) {
                    $existing->update(array_merge($data, ['uuid' => $uuid]));
                    return;
                }
            }
            throw $e;
        }
    }

    private function handleUpdate(string $modelClass, string $uuid, array $data)
    {
        $record = $modelClass::where('uuid', $uuid)->first();
        
        if (!$record) {
            // Try to find by other unique fields
            if (strpos($modelClass, 'User') !== false && isset($data['email'])) {
                $record = $modelClass::where('email', $data['email'])->first();
            } elseif (strpos($modelClass, 'Ticket') !== false && isset($data['ticket_code'])) {
                $record = $modelClass::where('ticket_code', $data['ticket_code'])->first();
            }
            
            if (!$record) {
                // Create if doesn't exist
                $modelClass::create($data);
                return;
            }
        }

        // Always update (remove timestamp check for now)
        $record->update($data);
    }

    private function handleDelete(string $modelClass, string $uuid)
    {
        $record = $modelClass::where('uuid', $uuid)->first();
        if ($record) {
            $record->delete();
        }
    }

    public function syncBatch(Request $request)
    {
        $items = $request->input('items', []);
        $results = [];

        DB::beginTransaction();

        try {
            foreach ($items as $item) {
                $modelClass = $item['model_type'];
                $uuid = $item['uuid'];
                $action = $item['action'];
                $data = $item['data'];

                switch ($action) {
                    case 'create':
                        $this->handleCreate($modelClass, $uuid, $data);
                        break;
                    case 'update':
                        $this->handleUpdate($modelClass, $uuid, $data);
                        break;
                    case 'delete':
                        $this->handleDelete($modelClass, $uuid);
                        break;
                }

                $results[] = ['uuid' => $uuid, 'status' => 'success'];
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Batch sync completed',
                'results' => $results
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Batch sync failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}