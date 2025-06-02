<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CargoSetting;
use App\Models\DepartureFee;
use Illuminate\Support\Facades\Auth;

class CargoSettingsController extends Controller
{
    /**
     * Show cargo settings and departure fee settings.
     */
    public function index()
    {
        $setting = CargoSetting::first();
        $departureFees = DepartureFee::pluck('fee', 'level')->toArray();

        return view('admin.cargo_settings.index', compact('setting', 'departureFees'));
    }

    /**
     * Edit cargo settings and departure fee settings.
     */
    public function edit()
    {
        $setting = CargoSetting::first();
        $departureFees = DepartureFee::pluck('fee', 'level')->toArray();

        return view('admin.cargo_settings.edit', compact('setting', 'departureFees'));
    }

    /**
     * Update cargo fee/tax/service settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'fee_per_km' => 'required|numeric|min:0',
            'tax_percent' => 'required|numeric|min:0',
            'service_fee' => 'required|numeric|min:0',
        ]);

        $setting = CargoSetting::first();
        $setting->update($request->only(['fee_per_km', 'tax_percent', 'service_fee']));

        return redirect()->route('admin.cargo-settings.index')->with('success', 'Cargo settings updated!');
    }

    /**
     * Update departure fee for each bus level.
     */
    public function updateDepartureFee(Request $request)
    {
        $request->validate([
            'level1' => 'required|numeric|min:0',
            'level2' => 'required|numeric|min:0',
            'level3' => 'required|numeric|min:0',
        ]);

        // Loop through and update or insert each level's fee
        foreach (['level1', 'level2', 'level3'] as $level) {
            DepartureFee::updateOrCreate(
                ['level' => $level],
                ['fee' => $request->input($level)]
            );
        }

        return back()->with('success', 'Departure fees saved to database successfully.');
    }
}
