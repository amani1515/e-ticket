<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SmsTemplate;
use Illuminate\Http\Request;

class SmsTemplateController extends Controller
{
    /**
     * Display a listing of the SMS templates.
     */
    public function index()
    {
        $templates = SmsTemplate::orderBy('type')->orderBy('name')->get();
        return view('admin.sms_templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new SMS template.
     */
    public function create()
    {
        return view('admin.sms_templates.create');
    }

    /**
     * Store a newly created SMS template in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        SmsTemplate::create($request->only(['name', 'type', 'content']));

        return redirect()->route('admin.sms-template.index')
            ->with('success', 'SMS template created successfully.');
    }

    /**
     * Display the specified SMS template.
     */
    public function show(SmsTemplate $smsTemplate)
    {
        return view('admin.sms_templates.show', compact('smsTemplate'));
    }

    /**
     * Show the form for editing the specified SMS template.
     */
    public function edit(SmsTemplate $smsTemplate)
    {
        return view('admin.sms_templates.edit', compact('smsTemplate'));
    }

    /**
     * Update the specified SMS template in storage.
     */
    public function update(Request $request, SmsTemplate $smsTemplate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $smsTemplate->update($request->only(['name', 'type', 'content']));

        return redirect()->route('admin.sms-template.index')
            ->with('success', 'SMS template updated successfully.');
    }

    /**
     * Remove the specified SMS template from storage.
     */
    public function destroy(SmsTemplate $smsTemplate)
    {
        $smsTemplate->delete();

        return redirect()->route('admin.sms-template.index')
            ->with('success', 'SMS template deleted successfully.');
    }
}