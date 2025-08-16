@extends('admin.layout.app')

@section('content')
<div class="p-6 bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-lg mb-6">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 flex items-center">
                    <svg class="w-8 h-8 mr-3 text-blue-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Data Synchronization Hub
                </h2>
                <p class="text-gray-600 mt-1">Real-time sync monitoring and management dashboard</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 rounded-full {{ $status['online'] ? 'bg-green-400 animate-pulse' : 'bg-red-400' }}"></div>
                    <span id="connection-status" class="px-4 py-2 rounded-full text-sm font-medium {{ $status['online'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $status['online'] ? '🟢 Connected' : '🔴 Disconnected' }}
                    </span>
                </div>
                <button onclick="syncNow()" id="sync-btn" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 active:scale-95">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Sync Now
                </button>
            </div>
        </div>
    </div>

    <!-- Interactive Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition duration-300 transform hover:scale-105 cursor-pointer" onclick="filterByStatus('all')">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Items</p>
                    <p class="text-3xl font-bold" id="total-items">{{ $status['pending'] + $status['failed'] }}</p>
                    <p class="text-blue-200 text-xs mt-1">Click to view all</p>
                </div>
                <div class="bg-blue-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition duration-300 transform hover:scale-105 cursor-pointer" onclick="filterByStatus('pending')">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Pending Sync</p>
                    <p id="pending-count" class="text-3xl font-bold">{{ $status['pending'] }}</p>
                    <p class="text-yellow-200 text-xs mt-1">Click to filter</p>
                </div>
                <div class="bg-yellow-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition duration-300 transform hover:scale-105 cursor-pointer" onclick="filterByStatus('failed')">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Failed Items</p>
                    <p id="failed-count" class="text-3xl font-bold">{{ $status['failed'] }}</p>
                    <p class="text-red-200 text-xs mt-1">Click to filter</p>
                </div>
                <div class="bg-red-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition duration-300 transform hover:scale-105">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Success Rate</p>
                    <p id="success-rate" class="text-3xl font-bold">95%</p>
                    <p class="text-green-200 text-xs mt-1" id="last-sync">{{ $status['last_sync'] }}</p>
                </div>
                <div class="bg-green-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Control Panel -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Quick Actions
            </h3>
            <div class="space-y-3">
                <button onclick="retryFailed()" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-4 py-3 rounded-lg font-medium transition duration-200 shadow-md hover:shadow-lg transform hover:scale-105">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Retry All Failed
                </button>
                <button onclick="clearFailed()" class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-4 py-3 rounded-lg font-medium transition duration-200 shadow-md hover:shadow-lg transform hover:scale-105">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Clear All Failed
                </button>
                <button onclick="refreshData()" class="w-full bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white px-4 py-3 rounded-lg font-medium transition duration-200 shadow-md hover:shadow-lg transform hover:scale-105">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Refresh Data
                </button>
            </div>
        </div>

        <!-- Auto Sync Settings -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Auto Sync
            </h3>
            <div class="space-y-4">
                <label class="flex items-center justify-between cursor-pointer p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-200">
                    <span class="text-sm font-medium text-gray-700">Enable Auto Sync</span>
                    <input type="checkbox" id="auto-sync-toggle" class="toggle-checkbox hidden">
                    <div class="toggle-switch bg-gray-300 rounded-full w-12 h-6 flex items-center transition duration-300 focus:outline-none shadow">
                        <div class="toggle-dot bg-white w-5 h-5 rounded-full shadow-md transform transition duration-300"></div>
                    </div>
                </label>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sync Interval</label>
                    <select id="auto-sync-interval" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3" disabled>
                        <option value="30">⚡ Every 30 seconds</option>
                        <option value="60" selected>🕐 Every 1 minute</option>
                        <option value="180">🕒 Every 3 minutes</option>
                        <option value="300">🕔 Every 5 minutes</option>
                    </select>
                </div>
                <div id="auto-sync-status" class="text-sm text-gray-500 hidden">
                    <span class="inline-flex items-center">
                        <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse mr-2"></div>
                        Auto-sync active
                    </span>
                </div>
            </div>
        </div>

        <!-- Live Statistics -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            Live Stats
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                    <span class="text-sm font-medium text-blue-700">Queue Size</span>
                    <span id="queue-size" class="text-lg font-bold text-blue-600">{{ $status['pending'] }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                    <span class="text-sm font-medium text-green-700">Synced Today</span>
                    <span id="synced-today" class="text-lg font-bold text-green-600">0</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-purple-50 rounded-lg">
                    <span class="text-sm font-medium text-purple-700">Avg Response</span>
                    <span id="avg-response" class="text-lg font-bold text-purple-600">~2.3s</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
            </svg>
            Filter & Search
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select id="status-filter" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3">
                    <option value="all">🔄 All Status</option>
                    <option value="pending">⏳ Pending</option>
                    <option value="synced">✅ Synced</option>
                    <option value="failed">❌ Failed</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Model Type</label>
                <select id="model-filter" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3">
                    <option value="all">📋 All Models</option>
                    <option value="User">👤 Users</option>
                    <option value="Ticket">🎫 Tickets</option>
                    <option value="CashReport">💰 Cash Reports</option>
                    <option value="Schedule">📅 Schedules</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
                <select id="date-filter" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3">
                    <option value="all">📅 All Time</option>
                    <option value="today">📆 Today</option>
                    <option value="week">📊 This Week</option>
                    <option value="month">📈 This Month</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" id="search-input" placeholder="🔍 Search UUID, model..." class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3">
            </div>
        </div>
    </div>

    <!-- Enhanced Data Table -->
    <div class="bg-white rounded-xl shadow-lg">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">Sync Activity Monitor</h3>
                    <p class="text-gray-600 mt-1">Real-time synchronization status and history</p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">Auto-refresh:</span>
                    <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attempts</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Attempt</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="sync-table-body" class="bg-white divide-y divide-gray-200">
                    @forelse($recentSync as $item)
                    <tr class="hover:bg-gray-50 transition duration-150 sync-row" data-status="{{ $item->synced ? 'synced' : ($item->retry_count >= 3 ? 'failed' : 'pending') }}" data-model="{{ class_basename($item->model_type) }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-md">
                                        <span class="text-xs font-bold text-white">{{ substr(class_basename($item->model_type), 0, 2) }}</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ class_basename($item->model_type) }}</div>
                                    <div class="text-xs text-gray-500">ID: {{ $item->model_id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                {{ $item->action === 'create' ? 'bg-green-100 text-green-800' : 
                                   ($item->action === 'update' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($item->action) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($item->synced)
                                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">✅ Synced</span>
                                @elseif($item->retry_count >= 3)
                                    <div class="w-2 h-2 bg-red-400 rounded-full mr-2"></div>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">❌ Failed</span>
                                @else
                                    <div class="w-2 h-2 bg-yellow-400 rounded-full mr-2 animate-pulse"></div>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">⏳ Pending</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="text-sm text-gray-900">{{ $item->retry_count }}</span>
                                @if($item->retry_count > 0)
                                    <span class="ml-2 text-xs text-red-500">({{ $item->retry_count }} retries)</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->created_at->format('M d, H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->last_attempt ? $item->last_attempt->format('M d, H:i') : 'Never' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @if(!$item->synced && $item->retry_count < 3)
                                <button onclick="retryItem({{ $item->id }})" class="text-blue-600 hover:text-blue-900 mr-3">Retry</button>
                            @endif
                            @if($item->retry_count >= 3)
                                <button onclick="deleteItem({{ $item->id }})" class="text-red-600 hover:text-red-900">Delete</button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-2.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 009.586 13H7"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No sync data available</h3>
                                <p class="text-gray-500">Start syncing to see activity here</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.toggle-checkbox:checked + .toggle-switch {
    background-color: #3B82F6;
}
.toggle-checkbox:checked + .toggle-switch .toggle-dot {
    transform: translateX(1.5rem);
}
</style>
@endsection

@section('scripts')
<script>
let autoSyncInterval = null;
let currentFilter = 'all';

function syncNow() {
    const btn = document.getElementById('sync-btn');
    const originalContent = btn.innerHTML;
    
    btn.disabled = true;
    btn.innerHTML = '<svg class="w-5 h-5 inline mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Syncing...';
    
    fetch('/admin/sync/now', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('✅ ' + data.message, 'success');
            updateStats();
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification('❌ Sync failed: ' + data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('❌ Connection error: ' + error.message, 'error');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = originalContent;
    });
}

function retryFailed() {
    fetch('/admin/sync/retry-failed', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('✅ ' + data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification('❌ ' + data.message, 'error');
        }
    });
}

function clearFailed() {
    if (confirm('🗑️ Are you sure you want to clear all failed items? This action cannot be undone.')) {
        fetch('/admin/sync/clear-failed', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('✅ ' + data.message, 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('❌ ' + data.message, 'error');
            }
        });
    }
}

function refreshData() {
    showNotification('🔄 Refreshing data...', 'info');
    setTimeout(() => location.reload(), 500);
}

function filterByStatus(status) {
    currentFilter = status;
    const rows = document.querySelectorAll('.sync-row');
    const statusFilter = document.getElementById('status-filter');
    statusFilter.value = status;
    
    rows.forEach(row => {
        const rowStatus = row.dataset.status;
        if (status === 'all' || rowStatus === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
    
    showNotification(`🔍 Filtered by: ${status}`, 'info');
}

function updateStats() {
    fetch('/admin/sync/status')
        .then(response => response.json())
        .then(data => {
            document.getElementById('pending-count').textContent = data.pending;
            document.getElementById('failed-count').textContent = data.failed;
            document.getElementById('queue-size').textContent = data.pending;
            
            const statusEl = document.getElementById('connection-status');
            statusEl.className = data.online ? 
                'px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800' : 
                'px-4 py-2 rounded-full text-sm font-medium bg-red-100 text-red-800';
            statusEl.textContent = data.online ? '🟢 Connected' : '🔴 Disconnected';
        });
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
    notification.className = `fixed top-4 right-4 ${bgColor} text-white p-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 translate-x-full`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => notification.classList.remove('translate-x-full'), 100);
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => notification.remove(), 300);
    }, 4000);
}

// Auto-sync functionality
document.getElementById('auto-sync-toggle').addEventListener('change', function() {
    const intervalSelect = document.getElementById('auto-sync-interval');
    const statusDiv = document.getElementById('auto-sync-status');
    
    if (this.checked) {
        intervalSelect.disabled = false;
        statusDiv.classList.remove('hidden');
        startAutoSync();
    } else {
        intervalSelect.disabled = true;
        statusDiv.classList.add('hidden');
        stopAutoSync();
    }
});

document.getElementById('auto-sync-interval').addEventListener('change', function() {
    if (document.getElementById('auto-sync-toggle').checked) {
        stopAutoSync();
        startAutoSync();
    }
});

function startAutoSync() {
    const interval = parseInt(document.getElementById('auto-sync-interval').value) * 1000;
    autoSyncInterval = setInterval(() => {
        syncNow();
    }, interval);
    showNotification('🔄 Auto-sync enabled', 'success');
}

function stopAutoSync() {
    if (autoSyncInterval) {
        clearInterval(autoSyncInterval);
        autoSyncInterval = null;
        showNotification('⏹️ Auto-sync disabled', 'success');
    }
}

// Filter functionality
document.getElementById('status-filter').addEventListener('change', function() {
    filterByStatus(this.value);
});

document.getElementById('model-filter').addEventListener('change', function() {
    const rows = document.querySelectorAll('.sync-row');
    const selectedModel = this.value;
    
    rows.forEach(row => {
        const rowModel = row.dataset.model;
        if (selectedModel === 'all' || rowModel === selectedModel) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

document.getElementById('search-input').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('.sync-row');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Auto-update disabled to prevent SSL errors
// setInterval(updateStats, 30000);
</script>
@endsection