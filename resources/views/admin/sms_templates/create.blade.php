@extends('admin.layout.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow mt-10">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Create SMS Template</h2>
        <a href="{{ route('admin.sms-template.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-800 transition">
            Back to Templates
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.sms-template.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Template Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="border rounded px-3 py-2 w-full text-gray-800" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Type</label>
            <input type="text" name="type" value="{{ old('type') }}" class="border rounded px-3 py-2 w-full text-gray-800" required placeholder="e.g. driver, user, mahberat">
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Message Content</label>
            <textarea name="content" class="border rounded px-3 py-2 w-full text-gray-800" rows="6" required>{{ old('content') }}</textarea>
        </div>
        
        <div class="flex gap-2">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-800 transition">
                Create Template
            </button>
            <a href="{{ route('admin.sms-template.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-800 transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection