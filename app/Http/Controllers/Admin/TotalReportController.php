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
    $totalSchedules = 0;
    $totalBaby = 0;
    $totalAdult = 0;
    $totalMiddleAged = 0;
    $totalSenior = 0;
    $totalNone = 0;
    $totalBlind = 0;
    $totalDeaf = 0;
    $totalSpeech = 0;
    
    // Bus level counts
    $totalLevel1Buses = 0;
    $totalLevel2Buses = 0;
    $totalLevel3Buses = 0;

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

        // Age status counts
        $destination->baby_count = $destination->tickets()
            ->where('age_status', 'baby')
            ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('created_at', '<=', $to))
            ->count();

        $destination->adult_count = $destination->tickets()
            ->where('age_status', 'adult')
            ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('created_at', '<=', $to))
            ->count();

        $destination->middle_aged_count = $destination->tickets()
            ->where('age_status', 'middle_aged')
            ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('created_at', '<=', $to))
            ->count();

        $destination->senior_count = $destination->tickets()
            ->where('age_status', 'senior')
            ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('created_at', '<=', $to))
            ->count();

        // Disability status counts
        $destination->none_disability = $destination->tickets()
            ->where('disability_status', 'None')
            ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('created_at', '<=', $to))
            ->count();

        $destination->blind_count = $destination->tickets()
            ->where('disability_status', 'Blind / Visual Impairment')
            ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('created_at', '<=', $to))
            ->count();

        $destination->deaf_count = $destination->tickets()
            ->where('disability_status', 'Deaf / Hard of Hearing')
            ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('created_at', '<=', $to))
            ->count();

        $destination->speech_count = $destination->tickets()
            ->where('disability_status', 'Speech Impairment')
            ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('created_at', '<=', $to))
            ->count();

        $scheduleCount = $destination->schedules()
            ->when($from, fn($q) => $q->whereDate('scheduled_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('scheduled_at', '<=', $to))
            ->count();

        $destination->schedule_count = $scheduleCount;
        $destination->total_km = $scheduleCount * ($destination->distance ?? 0);
        
        // Count buses by level for this destination
        $destination->level1_buses = $destination->schedules()
            ->join('buses', 'schedules.bus_id', '=', 'buses.id')
            ->where('buses.level', 'level1')
            ->when($from, fn($q) => $q->whereDate('schedules.scheduled_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('schedules.scheduled_at', '<=', $to))
            ->distinct('buses.id')
            ->count('buses.id');
            
        $destination->level2_buses = $destination->schedules()
            ->join('buses', 'schedules.bus_id', '=', 'buses.id')
            ->where('buses.level', 'level2')
            ->when($from, fn($q) => $q->whereDate('schedules.scheduled_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('schedules.scheduled_at', '<=', $to))
            ->distinct('buses.id')
            ->count('buses.id');
            
        $destination->level3_buses = $destination->schedules()
            ->join('buses', 'schedules.bus_id', '=', 'buses.id')
            ->where('buses.level', 'level3')
            ->when($from, fn($q) => $q->whereDate('schedules.scheduled_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('schedules.scheduled_at', '<=', $to))
            ->distinct('buses.id')
            ->count('buses.id');

        $totalTickets += $destination->tickets_count;
        $totalMale += $destination->male_count;
        $totalFemale += $destination->female_count;
        $totalKm += $destination->total_km;
        $totalSchedules += $scheduleCount;
        $totalBaby += $destination->baby_count;
        $totalAdult += $destination->adult_count;
        $totalMiddleAged += $destination->middle_aged_count;
        $totalSenior += $destination->senior_count;
        $totalNone += $destination->none_disability;
        $totalBlind += $destination->blind_count;
        $totalDeaf += $destination->deaf_count;
        $totalSpeech += $destination->speech_count;
        $totalLevel1Buses += $destination->level1_buses;
        $totalLevel2Buses += $destination->level2_buses;
        $totalLevel3Buses += $destination->level3_buses;
    }

    // Format message
    $dateRange = '';
    if ($from || $to) {
        // Check if it's today's filter
        $today = now()->format('Y-m-d');
        if ($from === $today && $to === $today) {
            $dateRange = ' ቀን : ' . $this->convertToEthiopian(now()) ;
        } else {
            $dateRange = ' (' . ($from ? 'From: ' . $from : '') . ($from && $to ? ' - ' : '') . ($to ? 'To: ' . $to : '') . ')';
        }
    }

    $message = " **ሴቫስቶፖል ቴክኖሎጅስ አዊ ዞን አዘና መናኸሪያ** \n\n" . $dateRange . "\n\n";
    // $message .= "📊 *ጠቅላላ ሪፖርት*\n";
    // $message .= "━━━━━━━━━━━━━━━━━━━━\n";
    // $message .= "👥 የተጓዥ ብዛት: *{$totalTickets}*\n";
    // $message .= "👨 ወንድ: *{$totalMale}* | 👩 ሴት: *{$totalFemale}*\n";
    // $message .= "👶 ታዳጊ: *{$totalBaby}* | 👦 ወጣት: *{$totalAdult}*\n";
    // $message .= "👨‍💼 ጎልማሳ: *{$totalMiddleAged}* | 👴 ሽማግሌ: *{$totalSenior}*\n";
    // $message .= "🚌 ጠቅላላ ስኬጁል: *{$totalSchedules}*\n";
    // $message .= "🛣️ Total KM: *{$totalKm} km*\n\n";

    $message .= "🎯 * ዝርዝር መረጃ *\n";
    $message .= "━━━━━━━━━━━━━━━━━━━━\n";

    foreach ($destinations as $destination) {
        if ($destination->tickets_count > 0) {
            $message .= "\n📍 *{$destination->destination_name}*\n";
            if ($destination->start_from) {
                $message .= "   መነሻ: {$destination->start_from}\n";
            }
            $message .= "   👥 የተጓዥ ብዛት: *{$destination->tickets_count}*\n";
            $message .= "   👨 ወንድ: **{$destination->male_count}** | 👩 ሴት: **{$destination->female_count}**\n";
            $message .= "   👶 ታዳጊ: **{$destination->baby_count}** | 👦 ወጣት: {$destination->adult_count} \n";
            $message .= "   👨‍💼 ጎልማሳ: {$destination->middle_aged_count} | 👴 ሽማግሌ: {$destination->senior_count}\n\n";
            $message .= "   ♿ የአካል ጉዳት: የሌለባቸው = *{$destination->none_disability}* | ማየት የተሳናቸው= *{$destination->blind_count}* | መስማት የተሳናቸው= *{$destination->deaf_count}* | መናገር የተሳናቸው= *{$destination->speech_count}*\n\n";
            $message .= "   🚌 የመርሀ-ግብር ብዛት: {$destination->schedule_count}\n";
            $message .= "   ከፍተኛ : **{$destination->level1_buses}** | መለስተኛ: **{$destination->level2_buses}** | አነስተኛ: **{$destination->level3_buses}**\n";
            $message .= "   🛣️ Distance: {$destination->total_km} km\n";
        }
    }

    $message .= "\n═══════════════════════════════════\n";
    $message .= "📊 **ጠቅላላ ሪፖርት SUMMARY**\n";
    
    $message .= "═══════════════════════════════════\n";
    $message .= "👥 **ጠቅላላ የተጓዥ ብዛት: {$totalTickets}**\n";
    $message .= "👨 ወንድ: **{$totalMale}** | 👩 ሴት: **{$totalFemale}**\n";
    $message .= "👶 ታዳጊ: **{$totalBaby}** | 👦 ወጣት: **{$totalAdult}**\n";
    $message .= "👨 ጎልማሳ: **{$totalMiddleAged}** | 👴 ሽማግሌ: **{$totalSenior}**\n \n";
    $message .= "♿ የአካል ጉዳት: የሌለባቸው =  **{$totalNone}** | ማየት  የተሳናቸው= **{$totalBlind}** | መስማት  የተሳናቸው= **{$totalDeaf}** | መናገር  የተሳናቸው= **{$totalSpeech}**\n \n";
    $message .= "🚌 **ጠቅላላ የመርሀ-ግብር ብዛት: {$totalSchedules}**\n";
    $message .= "**ከፍተኛ: {$totalLevel1Buses}** | **መለስተኛ: {$totalLevel2Buses}** | **አነስተኛ: {$totalLevel3Buses}**\n";
    $message .= "🛣️ **Total KM : {$totalKm} km**\n\n";
    $message .= "═══════════════════════════════════\n";
    $message .= "📅 Generated: " . now()->format('Y-m-d H:i:s') . "\n";
    $message .= "🏢 **E-TICKET SYSTEM**";

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

private function convertToEthiopian($date)
{
    $year = $date->year;
    $month = $date->month;
    $day = $date->day;
    
    // Ethiopian calendar is about 7-8 years behind
    $ethiopianYear = $year - 7;
    
    // Ethiopian New Year starts on Sept 11 (or 12 in leap years)
    $newYearDay = ($year % 4 == 0) ? 12 : 11;
    
    if ($month < 9 || ($month == 9 && $day < $newYearDay)) {
        $ethiopianYear--;
    }
    
    // Calculate Ethiopian day of year
    $dayOfYear = $date->dayOfYear;
    $newYearDayOfYear = mktime(0, 0, 0, 9, $newYearDay, $year);
    $newYearDayOfYear = date('z', $newYearDayOfYear) + 1;
    
    if ($dayOfYear >= $newYearDayOfYear) {
        $ethiopianDayOfYear = $dayOfYear - $newYearDayOfYear + 1;
    } else {
        $ethiopianDayOfYear = $dayOfYear + 365 - $newYearDayOfYear + 1;
    }
    
    // Convert to Ethiopian month/day
    $ethiopianMonth = intval(($ethiopianDayOfYear - 1) / 30) + 1;
    $ethiopianDay = (($ethiopianDayOfYear - 1) % 30) + 1;
    
    return "{$ethiopianDay}/{$ethiopianMonth}/{$ethiopianYear}";
}
}