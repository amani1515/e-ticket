<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TotalReportController extends Controller
{
public function index(Request $request)
{
    // Allow both admin and headoffice to view
    if (!auth()->check() || !in_array(auth()->user()->usertype, ['admin', 'headoffice'])) {
        return view('errors.403');
    }

    $from = $request->input('from_date');
    $to = $request->input('to_date');

    $destinations = \App\Models\Destination::withCount(['tickets' => function ($query) use ($from, $to) {
        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }
    }])->get();

    $totalTickets = 0;
    $totalMale = 0;
    $totalFemale = 0;
    $totalKm = 0;

    foreach ($destinations as $destination) {
        $destination->male_count = $destination->tickets()
            ->where('gender', 'male')
            ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('created_at', '<=', $to))
            ->count();

        $destination->female_count = $destination->tickets()
            ->where('gender', 'female')
            ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('created_at', '<=', $to))
            ->count();

        $scheduleCount = $destination->schedules()
            ->when($from, fn($q) => $q->whereDate('scheduled_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('scheduled_at', '<=', $to))
            ->count();

        $destination->total_km = $scheduleCount * ($destination->distance ?? 0);

        $totalTickets += $destination->tickets_count;
        $totalMale += $destination->male_count;
        $totalFemale += $destination->female_count;
        $totalKm += $destination->total_km;
    }

    return view('admin.reports.total', compact('destinations', 'totalTickets', 'totalMale', 'totalFemale', 'totalKm'));
}

public function exportToTelegram(Request $request)
{
    if (!auth()->check() || !in_array(auth()->user()->usertype, ['admin', 'headoffice'])) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $from = $request->input('from_date');
    $to = $request->input('to_date');

    $destinations = \App\Models\Destination::withCount(['tickets' => function ($query) use ($from, $to) {
        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }
    }])->get();

    $totalTickets = 0;
    $totalMale = 0;
    $totalFemale = 0;
    $totalKm = 0;

    foreach ($destinations as $destination) {
        $destination->male_count = $destination->tickets()
            ->where('gender', 'male')
            ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('created_at', '<=', $to))
            ->count();

        $destination->female_count = $destination->tickets()
            ->where('gender', 'female')
            ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('created_at', '<=', $to))
            ->count();

        $scheduleCount = $destination->schedules()
            ->when($from, fn($q) => $q->whereDate('scheduled_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('scheduled_at', '<=', $to))
            ->count();

        $destination->total_km = $scheduleCount * ($destination->distance ?? 0);

        $totalTickets += $destination->tickets_count;
        $totalMale += $destination->male_count;
        $totalFemale += $destination->female_count;
        $totalKm += $destination->total_km;
    }

    // Format message
    $dateRange = '';
    if ($from || $to) {
        $dateRange = ' (' . ($from ? 'From: ' . $from : '') . ($from && $to ? ' - ' : '') . ($to ? 'To: ' . $to : '') . ')';
    }

    $message = " ***** Sevastopol technologies ***** \n" . $dateRange . "\n\n";
    $message .= "📊 *ጠቅላላ ሪፖርት*\n";
    $message .= "━━━━━━━━━━━━━━━━━━━━\n";
    $message .= "👥 የተጓዥ ብዛት: *{$totalTickets}*\n";
    $message .= "👨 ወንድ: *{$totalMale}*\n";
    $message .= "👩 ሴት: *{$totalFemale}*\n";
    $message .= "🛣️ Total KM: *{$totalKm} km*\n\n";

    $message .= "🎯 * ዝርዝር መረጃ *\n";
    $message .= "━━━━━━━━━━━━━━━━━━━━\n";

    foreach ($destinations as $destination) {
        if ($destination->tickets_count > 0) {
            $message .= "\n📍 *{$destination->destination_name}*\n";
            if ($destination->start_from) {
                $message .= "   From: {$destination->start_from}\n";
            }
            $message .= "   👥 የተጓዥ ብዛት:: *{$destination->tickets_count}*\n";
            $message .= "   👨 ወንድ: {$destination->male_count} | 👩 ሴት  : {$destination->female_count}\n";
            $message .= "   🛣️ Distance: {$destination->total_km} km\n";
        }
    }

    $message .= "\n━━━━━━━━━━━━━━━━━━━━\n";
    $message .= "📅 Generated: " . now()->format('Y-m-d H:i:s') . "\n";
    $message .= "🏢 E-Ticket System";

    try {
        $response = Http::post("https://api.telegram.org/bot7730747858:AAEuouIJzrPKcd9YyWJ7jEWFL1AVFw3ouSc/sendMessage", [
            'chat_id' => '-1002659859951',
            'text' => $message,
            'parse_mode' => 'Markdown'
        ]);

        if ($response->successful()) {
            return response()->json(['success' => true, 'message' => 'Report exported to Telegram successfully!']);
        } else {
            return response()->json(['error' => 'Failed to send to Telegram'], 500);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
    }
}
}