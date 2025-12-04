<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Bus;
use App\Models\Schedule;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class TransportAuthorityController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));
        
        $tickets = Ticket::whereDate('created_at', $date)
            ->with(['destination', 'bus.mahberat', 'creator'])
            ->paginate(50);
            
        $buses = Bus::with('mahberat')->get();
        
        $schedules = Schedule::whereDate('created_at', $date)
            ->with(['destination', 'bus.mahberat'])
            ->get();

        return view('admin.transport-authority.index', compact('tickets', 'buses', 'schedules', 'date'));
    }

    public function send(Request $request)
    {
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));
        
        // Check if API URL is configured
        if (!env('TRANSPORT_API_URL')) {
            return back()->with('error', 'Transport Authority API URL not configured');
        }
        
        try {
            $response = Http::timeout(10)->asForm()->post(env('TRANSPORT_API_URL') . '/api/upload-csv', [
                'type' => 'all',
                'date' => $date,
                'csv_data' => $this->generateAllData($date),
                'api_key' => env('TRANSPORT_API_KEY')
            ]);

            if ($response->successful()) {
                return back()->with('success', 'Data sent successfully to Transport Authority');
            } else {
                return back()->with('error', 'Failed to send data: ' . $response->body());
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return back()->with('error', 'Cannot connect to Transport Authority server. Please ensure the API server is running on ' . env('TRANSPORT_API_URL'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    private function generateAllData($date)
    {
        $tickets = Ticket::whereDate('created_at', $date)
            ->with(['destination', 'bus.mahberat', 'creator'])
            ->get();

        $buses = Bus::with('mahberat')->get();

        $schedules = Schedule::whereDate('created_at', $date)
            ->with(['destination', 'bus.mahberat'])
            ->get();

        $data = [
            'tickets' => $tickets->map(function($ticket) {
                return [
                    'id' => $ticket->id,
                    'passenger_name' => $ticket->passenger_name,
                    'phone' => $ticket->phone_no,
                    'from' => $ticket->destination->start_from,
                    'to' => $ticket->destination->destination_name,
                    'tariff' => $ticket->tariff ?? $ticket->destination->tariff,
                    'bus_targa' => $ticket->bus->targa ?? $ticket->bus_id,
                    'mahberat' => $ticket->bus->mahberat->name ?? 'N/A',
                    'departure' => $ticket->departure_datetime,
                    'created_at' => $ticket->created_at
                ];
            }),
            'buses' => $buses->map(function($bus) {
                return [
                    'id' => $bus->id,
                    'targa' => $bus->targa,
                    'level' => $bus->level,
                    'capacity' => $bus->capacity,
                    'mahberat' => $bus->mahberat->name ?? 'N/A'
                ];
            }),
            'schedules' => $schedules->map(function($schedule) {
                return [
                    'id' => $schedule->id,
                    'from' => $schedule->destination->start_from,
                    'to' => $schedule->destination->destination_name,
                    'bus_targa' => $schedule->bus->targa ?? $schedule->bus_id,
                    'departure' => $schedule->departure_datetime,
                    'available_seats' => $schedule->available_seats
                ];
            })
        ];

        return json_encode($data);
    }

    public function export(Request $request)
    {
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));
        $data = json_decode($this->generateAllData($date), true);
        
        $filename = 'transport_authority_data_' . $date . '.json';
        
        return response()->json($data)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Content-Type', 'application/json');
    }
}