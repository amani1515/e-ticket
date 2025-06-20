<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\Schedule;
use Illuminate\Support\Facades\Http; // Use Laravel's HTTP client for Twilio API

class PublicDisplayController extends Controller
{
    public function showAllSchedules()
    {
        // Load destinations with their schedules and buses
        $destinations = Destination::with([
            'schedules' => function ($query) {
                $query->whereIn('status', ['queued', 'on loading'])->with('bus');
            }
        ])->get();

        return view('Public.bus-display', compact('destinations'));
    }
// Use Laravel HTTP client for Twilio API

public function notifySecondQueuedBus()
{
    // Find the 2nd queued bus (adjust query as needed)
    $secondQueued = Schedule::where('status', 'queued')
        ->orderBy('created_at')
        ->skip(1) // skip the first (1st) queued
        ->first();

    if ($secondQueued && $secondQueued->bus && $secondQueued->bus->driver_phone) {
        $to = $secondQueued->bus->driver_phone;
        // Format phone number for Twilio (E.164)
        if (strpos($to, '+') !== 0) {
            $to = '+251' . ltrim($to, '0');
        }
        $message = "ሰላም {$secondQueued->bus->driver_name}, መኪናዎ በሁለተኛ ተረኛ ቦታ ደርሷል። እባክዎ ለመጫን ዝግጁ ይሁኑ።";

        // Send SMS via Twilio HTTP API
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $from = env('TWILIO_FROM');

        $response = Http::withBasicAuth($sid, $token)
            ->asForm()
            ->post("https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json", [
                'From' => $from,
                'To' => $to,
                'Body' => $message,
            ]);

        // Optionally log or handle $response
        return $response->json();
    }

    return response()->json(['message' => 'No 2nd queued bus found or driver phone missing.']);
}
}
