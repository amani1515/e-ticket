<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CargoSetting;

class CargoSettingsController extends Controller
{
    public function index()
    {
        $setting = CargoSetting::first();
        return view('admin.cargo_settings.index', compact('setting'));
    }

    public function edit()
    {
        $setting = CargoSetting::first();
        return view('admin.cargo_settings.edit', compact('setting'));
    }

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
}