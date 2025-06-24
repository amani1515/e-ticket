<?php

namespace App\Http\Controllers\HisabShum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\DepartureFee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Bus;
use App\Models\Ticket;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Destination;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaction;
use Illuminate\Validation\Rule;


class PaidReportController extends Controller
{
    //
public function index()
{
    $schedules = \App\Models\Schedule::with(['bus', 'destination'])
        ->where('status', 'paid')
        ->orderByDesc('scheduled_at')
        ->get();

    // Loop through each schedule and add the fee from the departure_fees table
    foreach ($schedules as $schedule) {
        $schedule->departure_fee = \DB::table('departure_fees')
            ->where('level', $schedule->bus->level)
            ->value('fee') ?? 0.00; // fallback fee if not found
    }

    return view('hisabShum.paidReports', compact('schedules'));
}

// public function departedCertificate($id)
// {
//     $schedule = \App\Models\Schedule::with(['bus', 'destination'])->findOrFail($id);
//     $schedule->status = 'departed';
//     $schedule->save();

//     return view('hisabShum.certificate', compact('schedule'));
// }
public function certificate($id)
{
    $schedule = \App\Models\Schedule::with(['bus', 'destination'])->findOrFail($id);
    $schedule->status = 'departed';
    $schedule->departed_by = auth()->id();
    $schedule->departed_at = now();
    $schedule->save();
    return view('hisabShum.certificate', compact('schedule'));

}



 public function showPayForm(Schedule $schedule)
    {
        // Get the bus level for this schedule
        $busLevel = $schedule->bus->level ?? null;

        // Get the fee amount for the bus level
        $feeRecord = DepartureFee::where('level', $busLevel)->first();
        $feeAmount = $feeRecord ? $feeRecord->fee : 0;

        return view('hisabShum.pay_form', compact('schedule', 'feeAmount'));
    }

    // Handle payment initialization and redirect to Chapa
    public function pay(Request $request, Schedule $schedule)
    {
        // Get the fee amount again for security
        $busLevel = $schedule->bus->level ?? null;
        $feeRecord = DepartureFee::where('level', $busLevel)->first();
        $amount = $feeRecord ? $feeRecord->fee : 0;

        if ($amount <= 0) {
            return back()->with('error', 'Invalid fee amount for this bus level.');
        }

        $data = [
            'amount' => $amount,
            'currency' => 'ETB',
            'email' => auth()->user()->email ?? 'customer@example.com', // Replace with real user email if possible
            'first_name' => auth()->user()->name ?? 'Customer',          // Replace with real user name
            'tx_ref' => uniqid('txn_'),
            'callback_url' => route('hisabShum.schedule.callback'),
            'return_url' => route('hisabShum.schedule.callback'),
            'customization[title]' => 'Mewucha Fee Payment',
            'customization[description]' => "Payment for bus schedule #{$schedule->id}",
        ];

        $response = Http::withToken(env('CHAPA_SECRET_KEY'))
            ->post(env('CHAPA_BASE_URL') . '/transaction/initialize', $data);

        if ($response->successful()) {
            $paymentUrl = $response->json()['data']['checkout_url'];

            // Store schedule ID and tx_ref for callback verification
            session([
                'schedule_id' => $schedule->id,
                'tx_ref' => $data['tx_ref'],
            ]);

            return redirect($paymentUrl);
        }

        return back()->with('error', 'Failed to initialize payment. Please try again.');
    }


public function callback(Request $request)
{
    $txRef = session('tx_ref');
    $scheduleId = session('schedule_id');
    $payment_method_detail = session('payment_method_detail', 'unknown');

    if (!$txRef || !$scheduleId) {
        return redirect()->route('hisabShum.paid_reports.index')->with('error', 'Session expired or missing payment data.');
    }

    // Verify transaction from Chapa
    $verifyResponse = Http::withToken(env('CHAPA_SECRET_KEY'))
        ->get(env('CHAPA_BASE_URL') . '/transaction/verify/' . $txRef);

    if ($verifyResponse->successful() && $verifyResponse['status'] === 'success') {
        $paymentData = $verifyResponse['data'];

        // Update the schedule's mewucha_fee (if not already updated)
    $schedule = Schedule::findOrFail($scheduleId);

        if ($schedule->mewucha_fee == 0 || is_null($schedule->mewucha_fee)) {
            $schedule->update([
                'mewucha_fee' => $paymentData['amount'],
                'mewucha_status' => 'paid'
            ]);
        }


        // Record transaction
        Transaction::create([
            'tx_ref' => $txRef,
            'amount' => $paymentData['amount'],
            'currency' => $paymentData['currency'] ?? 'ETB',
            'payment_method' => 'chapa',
            'payment_method_detail' => $payment_method_detail,
            'level' => $schedule->bus->level ?? 'unknown',

            'schedule_id' => $schedule->id,
            'status' => 'paid',
        ]);

        // Clear session
        session()->forget(['tx_ref', 'schedule_id', 'payment_method_detail']);

        return redirect()->route('hisabShum.paidReports')->with('success', 'Payment completed successfully.');
    }

    return redirect()->route('hisabShum.paidReports')->with('error', 'Payment verification failed.');
}


public function payWithCash($id)
{
    $schedule = \App\Models\Schedule::with('bus')->findOrFail($id);

    // Get the bus level for this schedule
    $busLevel = $schedule->bus->level ?? null;

    // Get the fee amount for the bus level
    $feeRecord = \App\Models\DepartureFee::where('level', $busLevel)->first();
    $feeAmount = $feeRecord ? $feeRecord->fee : 0;

    // Update schedule: set fee, mark as paid, and set as departed
    $schedule->mewucha_fee = $feeAmount;
    $schedule->mewucha_status = 'paid';
    $schedule->status = 'departed';
    $schedule->departed_by = auth()->id();
    $schedule->departed_at = now();
    $schedule->save();

    // Log transaction
    \App\Models\Transaction::create([
        'tx_ref' => 'cash-' . uniqid(),
        'amount' => $feeAmount,
        'currency' => 'ETB',
        'payment_gateway' => 'cash',
        'payment_method' => 'cash',
        'level' => $busLevel ?? 'unknown',
        'schedule_id' => $schedule->id,
        'status' => 'paid',
        'paid_at' => now(),
    ]);

    return back()->with('success', 'Payment marked as paid with cash and bus marked as departed.');
}
}
