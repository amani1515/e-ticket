<!-- filepath: d:\My comany\e-ticket\resources\views\admin\sms_templates\index.blade.php -->
@extends('admin.layout.app')

@section('content')
    <div class="max-w-5xl mx-auto bg-white p-6 rounded shadow mt-10">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">All SMS Templates</h2>
            <button id="add-template-btn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-800 transition"
                onclick="document.getElementById('add-template-modal').classList.remove('hidden')">
                Add Template
            </button>
        </div>

        <!-- Modal Form (hidden by default) -->
        <div id="add-template-modal"
            class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded shadow-lg max-w-md w-full p-6 relative">
                <button class="absolute top-2 right-2 text-gray-500 hover:text-red-600 text-2xl font-bold"
                    onclick="document.getElementById('add-template-modal').classList.add('hidden')"
                    type="button">&times;</button>
                <h2 class="text-xl font-bold mb-4">Create New SMS Template</h2>
                <form method="POST" action="{{ route('admin.sms-template.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm mb-1">Template Name</label>
                        <input type="text" name="name" class="border rounded px-2 py-1 w-full text-gray-800" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm mb-1">Type</label>
                        <input type="text" name="type" class="border rounded px-2 py-1 w-full text-gray-800" required
                            placeholder="e.g. driver, user, mahberat">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm mb-1">Message Content</label>
                        <textarea name="content" class="border rounded px-2 py-1 w-full text-gray-800" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="mt-4 bg-green-600 text-white px-4 py-2 rounded">Save</button>
                </form>
            </div>
        </div>

        <table class="w-full border mt-6">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Type</th>
                    <th class="border px-4 py-2">Content</th>
                    <th class="border px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($templates as $template)
                    <tr>
                        <td class="border px-4 py-2">{{ $template->name }}</td>
                        <td class="border px-4 py-2">{{ $template->type }}</td>
                        <td class="border px-4 py-2">{{ $template->content }}</td>
                        <td class="border px-4 py-2 text-center">
                            <div class="flex gap-2 justify-center">
                                <a href="{{ route('admin.sms-template.show', $template->id) }}"
                                    class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-800 text-sm">View</a>
                                <a href="{{ route('admin.sms-template.edit', $template->id) }}"
                                    class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-800 text-sm">Edit</a>
                                <form action="{{ route('admin.sms-template.destroy', $template->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this template?');"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-800 text-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
