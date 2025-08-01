@extends('admin.layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 to-amber-100 py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-amber-900 mb-2">💳 Transaction Reports</h1>
            <p class="text-amber-700">Monitor and analyze all payment transactions</p>
        </div>

        <!-- Filters Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-amber-500 to-yellow-500 px-8 py-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filter Transactions
                </h2>
                <p class="text-amber-100 mt-2">Use filters to find specific transactions</p>
            </div>
            <div class="px-8 py-6">
                <form method="GET" action="{{ route('admin.reports.transactions') }}" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
                        <!-- Level Filter -->
                        <div>
                            <label for="level" class="block text-sm font-semibold text-amber-800 mb-2 uppercase tracking-wide">Level</label>
                            <div class="relative">
                                <select name="level" id="level" class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50">
                                    <option value="">All Levels</option>
                                    <option value="level1" {{ (isset($filters['level']) && $filters['level'] == 'level1') ? 'selected' : '' }}>🥉 Level 1</option>
                                    <option value="level2" {{ (isset($filters['level']) && $filters['level'] == 'level2') ? 'selected' : '' }}>🥈 Level 2</option>
                                    <option value="level3" {{ (isset($filters['level']) && $filters['level'] == 'level3') ? 'selected' : '' }}>🥇 Level 3</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Date Filter -->
                        <div>
                            <label for="date_filter" class="block text-sm font-semibold text-amber-800 mb-2 uppercase tracking-wide">Quick Filter</label>
                            <div class="relative">
                                <select name="date_filter" id="date_filter" class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50">
                                    <option value="">Select Period</option>
                                    <option value="today" {{ (isset($filters['date_filter']) && $filters['date_filter'] == 'today') ? 'selected' : '' }}>📅 Today</option>
                                    <option value="thisweek" {{ (isset($filters['date_filter']) && $filters['date_filter'] == 'thisweek') ? 'selected' : '' }}>📊 This Week</option>
                                    <option value="thismonth" {{ (isset($filters['date_filter']) && $filters['date_filter'] == 'thismonth') ? 'selected' : '' }}>📈 This Month</option>
                                    <option value="thisyear" {{ (isset($filters['date_filter']) && $filters['date_filter'] == 'thisyear') ? 'selected' : '' }}>📆 This Year</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Date From -->
                        <div>
                            <label for="date_from" class="block text-sm font-semibold text-amber-800 mb-2 uppercase tracking-wide">From Date</label>
                            <div class="relative">
                                <input type="date" name="date_from" id="date_from" value="{{ $filters['date_from'] ?? '' }}" 
                                    class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50" />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a1 1 0 011 1v8a1 1 0 01-1 1H5a1 1 0 01-1-1V8a1 1 0 011-1h3z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Date To -->
                        <div>
                            <label for="date_to" class="block text-sm font-semibold text-amber-800 mb-2 uppercase tracking-wide">To Date</label>
                            <div class="relative">
                                <input type="date" name="date_to" id="date_to" value="{{ $filters['date_to'] ?? '' }}" 
                                    class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50" />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a1 1 0 011 1v8a1 1 0 01-1 1H5a1 1 0 01-1-1V8a1 1 0 011-1h3z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col justify-end space-y-2">
                            <button type="submit" class="bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 text-white font-bold py-3 px-6 rounded-xl transition duration-200 transform hover:scale-105 shadow-lg flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                Filter
                            </button>
                            <a href="{{ route('admin.reports.transactions') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-xl transition duration-200 text-center flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Amount -->
            <div class="bg-gradient-to-br from-green-400 to-emerald-500 rounded-2xl shadow-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium uppercase tracking-wide">Total Amount</p>
                        <p class="text-3xl font-bold mt-2">{{ number_format($totalAmount, 2) }}</p>
                        <p class="text-green-100 text-sm mt-1">ETB</p>
                    </div>
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Transactions -->
            <div class="bg-gradient-to-br from-blue-400 to-indigo-500 rounded-2xl shadow-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium uppercase tracking-wide">Total Transactions</p>
                        <p class="text-3xl font-bold mt-2">{{ number_format($transactions->total()) }}</p>
                        <p class="text-blue-100 text-sm mt-1">Records</p>
                    </div>
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Average Transaction -->
            <div class="bg-gradient-to-br from-purple-400 to-pink-500 rounded-2xl shadow-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium uppercase tracking-wide">Average Amount</p>
                        <p class="text-3xl font-bold mt-2">{{ $transactions->total() > 0 ? number_format($totalAmount / $transactions->total(), 2) : '0.00' }}</p>
                        <p class="text-purple-100 text-sm mt-1">ETB per transaction</p>
                    </div>
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Success Rate -->
            {{-- <div class="bg-gradient-to-br from-orange-400 to-red-500 rounded-2xl shadow-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium uppercase tracking-wide">Success Rate</p>
                        <p class="text-3xl font-bold mt-2">{{ $transactions->total() > 0 ? number_format(($transactions->where('status', 'success')->count() / $transactions->total()) * 100, 1) : '0.0' }}%</p>
                        <p class="text-orange-100 text-sm mt-1">Successful payments</p>
                    </div>
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div> --}}
        </div>


        <!-- Transactions Table -->
        @if($transactions->count())
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-200">
                <h3 class="text-2xl font-bold text-amber-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Transaction Records
                </h3>
                <p class="text-amber-700 mt-2">Showing {{ $transactions->count() }} of {{ $transactions->total() }} transactions</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-amber-50 to-yellow-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-amber-800 uppercase tracking-wider">Transaction Ref</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-amber-800 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-amber-800 uppercase tracking-wider">Payment Method</th>
                            {{-- <th class="px-6 py-4 text-left text-xs font-bold text-amber-800 uppercase tracking-wider">Collected By</th> --}}
                            <th class="px-6 py-4 text-left text-xs font-bold text-amber-800 uppercase tracking-wider">Level</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-amber-800 uppercase tracking-wider">Schedule</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-amber-800 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-amber-800 uppercase tracking-wider">Date & Time</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($transactions as $transaction)
                        <tr class="hover:bg-amber-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-yellow-500 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">{{ $transaction->tx_ref }}</div>
                                        <div class="text-xs text-gray-500">{{ strtoupper($transaction->currency) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-lg font-bold text-green-600">{{ number_format($transaction->amount, 2) }}</div>
                                <div class="text-xs text-gray-500">ETB</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900 capitalize">{{ $transaction->payment_method }}</span>
                            </td>
                            {{-- <td class="px-6 py-4 whitespace-nowrap">
                                @if($transaction->collected_by)
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center mr-2">
                                            <span class="text-white text-xs font-bold">{{ substr($transaction->collected_by, 0, 1) }}</span>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{ $transaction->collected_by }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td> --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($transaction->level)
                                    @if($transaction->level === 'level1')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-bronze-100 text-bronze-800">
                                            🥉 Level 1
                                        </span>
                                    @elseif($transaction->level === 'level2')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            🥈 Level 2
                                        </span>
                                    @elseif($transaction->level === 'level3')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            🥇 Level 3
                                        </span>
                                    @endif
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($transaction->schedule_id)
                                    <div class="text-sm font-medium text-blue-600">#{{ $transaction->schedule_id }}</div>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(strtolower($transaction->status) === 'success')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Success
                                    </span>
                                @elseif(strtolower($transaction->status) === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Pending
                                    </span>
                                @elseif(strtolower($transaction->status) === 'failed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Failed
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 capitalize">
                                        {{ $transaction->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $transaction->created_at->format('M j, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $transaction->created_at->format('H:i A') }}</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-8 py-6 border-t border-gray-200">
                {{ $transactions->withQueryString()->links() }}
            </div>
        </div>
        @else
        <!-- No Transactions Found -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-8 py-16 text-center">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No Transactions Found</h3>
                <p class="text-gray-600 mb-6">There are no transactions matching your current filters.</p>
                <a href="{{ route('admin.reports.transactions') }}" class="inline-flex items-center px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Clear Filters
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
