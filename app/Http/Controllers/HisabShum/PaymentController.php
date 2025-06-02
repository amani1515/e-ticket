<?php

namespace App\Http\Controllers\HisabShum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Schedule;

class PaymentController extends Controller
{
    /**
     * Start Chapa payment
     */
public function initiate($scheduleId)
{
    $schedule = Schedule::with('bus')->findOrFail($scheduleId);

    $fee = DB::table('departure_fees')
        ->where('level', $schedule->bus->level)
        ->value('fee') ?? 10.00;

    $tx_ref = 'HISAB-' . \Str::random(10);

    $payload = [
        'amount' => $fee,
        'currency' => 'ETB',
        'email' => $schedule->bus->owner_email ?? 'test@example.com',
        'first_name' => $schedule->bus->owner_name ?? 'Bus',
        'last_name' => 'Owner',
        'tx_ref' => $tx_ref,
        'callback_url' => route('hisabShum.payment.callback'),
        'return_url' => route('hisabShum.payment.callback'),
        'customization' => [
            'title' => 'Bus Departure Fee',
            'description' => 'Payment for your schedule'
        ]
    ];

    $response = Http::withToken(env('CHAPA_SECRET_KEY'))
        ->post('https://api.chapa.co/v1/transaction/initialize', $payload);

    $data = $response->json();

    if (isset($data['status']) && $data['status'] === 'success') {
        return redirect($data['data']['checkout_url']);
    }

    return back()->with('error', $data['message'] ?? 'Payment failed.');
}


    /**
     * Handle Chapa callback
     */
    public function handleCallback(Request $request)
    {
        $tx_ref = $request->input('tx_ref');

        if (!$tx_ref) {
            return redirect()->route('hisabShum.paidReports')->with('error', 'No transaction reference.');
        }

        $verify = Http::withToken(env('CHAPA_SECRET_KEY'))
                    ->get("https://api.chapa.co/v1/transaction/verify/{$tx_ref}");

        $data = $verify->json();

        if ($data['status'] === 'success' && $data['data']['status'] === 'success') {
            // Example: mark paid
            // DB::table('schedules')->where('id', ...)->update(['is_paid' => 1]);

            return redirect()->route('hisabShum.paidReports')->with('success', 'Payment successful!');
        }

        return redirect()->route('hisabShum.paidReports')->with('error', 'Payment verification failed.');
    }
}
