@extends('admin.layout.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow mt-10">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">SMS Template Details</h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.sms-template.edit', $smsTemplate) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-800 transition">
                Edit
            </a>
            <a href="{{ route('admin.sms-template.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-800 transition">
                Back to Templates
            </a>
        </div>
    </div>

    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Template Name</label>
            <div class="bg-gray-50 border rounded px-3 py-2">{{ $smsTemplate->name }}</div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
            <div class="bg-gray-50 border rounded px-3 py-2">{{ $smsTemplate->type }}</div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Message Content</label>
            <div class="bg-gray-50 border rounded px-3 py-2 whitespace-pre-wrap">{{ $smsTemplate->content }}</div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Created</label>
            <div class="bg-gray-50 border rounded px-3 py-2">{{ $smsTemplate->created_at->format('Y-m-d H:i:s') }}</div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Last Updated</label>
            <div class="bg-gray-50 border rounded px-3 py-2">{{ $smsTemplate->updated_at->format('Y-m-d H:i:s') }}</div>
        </div>
    </div>

    <div class="mt-6 pt-4 border-t">
        <form action="{{ route('admin.sms-template.destroy', $smsTemplate) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this template?');" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-800 transition">
                Delete Template
            </button>
        </form>
    </div>
</div>
@endsection