<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CargoSetting;
use App\Models\DepartureFee;
use App\Models\SmsTemplate; // Add this
use Illuminate\Support\Facades\Auth;

class CargoSettingsController extends Controller
{
    /**
     * Show cargo settings and departure fee settings.
     */
    public function index()
    {
        $setting = CargoSetting::first();
        
        // Create default settings if none exist
        if (!$setting) {
            $setting = CargoSetting::create([
                'fee_per_km' => 0.00,
                'tax_percent' => 0.00,
                'service_fee' => 0.00,
            ]);
        }
        
        $departureFees = DepartureFee::pluck('fee', 'level')->toArray();
        $driverSmsTemplate = SmsTemplate::where('type', 'driver')->first(); // Fetch driver SMS template

        return view('admin.cargo_settings.index', compact('setting', 'departureFees', 'driverSmsTemplate'));
    }

    /**
     * Edit cargo settings and departure fee settings.
     */
    public function edit()
    {
        $setting = CargoSetting::first();
        
        // Create default settings if none exist
        if (!$setting) {
            $setting = CargoSetting::create([
                'fee_per_km' => 0.00,
                'tax_percent' => 0.00,
                'service_fee' => 0.00,
            ]);
        }
        
        $departureFees = DepartureFee::pluck('fee', 'level')->toArray();

        return view('admin.cargo_settings.edit', compact('setting', 'departureFees'));
    }


public function smsTemplateIndex()
{
    $templates = \App\Models\SmsTemplate::all();
    return view('admin.sms_templates.index', compact('templates'));
}

    public function createSmsTemplate()
{
    return view('admin.cargo_settings.index');
}

public function storeSmsTemplate(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'content' => 'required|string',
    ]);
    \App\Models\SmsTemplate::create($request->only(['name', 'type', 'content']));
    return redirect()->back()->with('success', 'SMS Template created successfully!');
}
public function destroySmsTemplate($id)
{
    \App\Models\SmsTemplate::findOrFail($id)->delete();
    return back()->with('success', 'SMS Template deleted!');
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
        
        // Create default settings if none exist
        if (!$setting) {
            $setting = CargoSetting::create([
                'fee_per_km' => 0.00,
                'tax_percent' => 0.00,
                'service_fee' => 0.00,
            ]);
        }
        
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

    /**
     * Update driver SMS template.
     */
    public function updateSmsTemplate(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $template = SmsTemplate::findOrFail($id);
        $template->content = $request->input('content');
        $template->save();

        return back()->with('success', 'Driver SMS template updated!');
    }
}