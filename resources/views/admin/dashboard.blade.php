@extends('admin.layout.app')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Welcome, {{ Auth::user()->name }}</h2>
    
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">🔄 Background Sync Settings</h3>
        
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-700">Auto sync status:</p>
                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $syncEnabled ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $syncEnabled ? 'Active' : 'Inactive' }}
                </span>
            </div>
            
            <form action="{{ route('admin.sync.toggle') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 rounded-lg font-medium transition {{ $syncEnabled ? 'bg-red-500 hover:bg-red-600 text-white' : 'bg-green-500 hover:bg-green-600 text-white' }}">
                    {{ $syncEnabled ? 'Deactivate' : 'Activate' }} Sync
                </button>
            </form>
        </div>
    </div>
@endsection
