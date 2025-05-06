@extends('admin.layout.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">All Cash Reports</h2>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('admin.cash.reports') }}" id="filter-form" class="mb-6 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <div>
            <label for="date_filter" class="block text-sm font-medium text-gray-700">Date</label>
            <select name="date_filter" id="date_filter" class="w-full p-2 border rounded">
                <option value="">All Dates</option>
                <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                <option value="yesterday" {{ request('date_filter') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>This Week</option>
                <option value="last_week" {{ request('date_filter') == 'last_week' ? 'selected' : '' }}>Last Week</option>
                <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>This Month</option>
                <option value="this_year" {{ request('date_filter') == 'this_year' ? 'selected' : '' }}>This Year</option>
                <option value="last_year" {{ request('date_filter') == 'last_year' ? 'selected' : '' }}>Last Year</option>
            </select>
        </div>

        <div>
            <label for="ticketer_id" class="block text-sm font-medium text-gray-700">Ticketer</label>
            <select name="ticketer_id" id="ticketer_id" class="w-full p-2 border rounded">
                <option value="">All Ticketers</option>
                @foreach($ticketers as $ticketer)
                    <option value="{{ $ticketer->id }}" {{ request('ticketer_id') == $ticketer->id ? 'selected' : '' }}>
                        {{ $ticketer->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="w-full p-2 border rounded">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="received" {{ request('status') == 'received' ? 'selected' : '' }}>Received</option>
            </select>
        </div>

        <div>
            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}" class="w-full p-2 border rounded" placeholder="ID, Ticketer Name">
        </div>
    </form>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold text-gray-700">Grand Total</h3>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($totals->grand_total ?? 0, 2) }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold text-gray-700">Total Tax</h3>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($totals->total_tax ?? 0, 2) }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold text-gray-700">Total Service Fee</h3>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($totals->total_service_fee ?? 0, 2) }}</p>
        </div>
    </div>

    <!-- Reports Table -->
    <table class="min-w-full bg-white rounded shadow">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-3">Ticketer</th>
                <th class="p-3">Amount</th>
                <th class="p-3">Tax</th>
                <th class="p-3">Service Fee</th>
                <th class="p-3">Date</th>
                <th class="p-3">Status</th>
                <th class="p-3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
            <tr class="border-t">
                <td class="p-3">{{ $report->user->name }}</td>
                <td class="p-3">{{ number_format($report->total_amount, 2) }}</td>
                <td class="p-3">{{ number_format($report->tax, 2) }}</td>
                <td class="p-3">{{ number_format($report->service_fee, 2) }}</td>
                <td class="p-3">{{ $report->report_date }}</td>
                <td class="p-3">
                    @if($report->status == 'received')
                        <span class="text-green-600 font-semibold">Received</span>
                    @else
                        <span class="text-yellow-600 font-semibold">Pending</span>
                    @endif
                </td>
                <td class="p-3">
                    @if($report->status !== 'received')
                        <form action="{{ route('admin.cash.reports.receive', $report->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">Mark Received</button>
                        </form>
                    @else
                        —
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $reports->links() }} <!-- Pagination links -->
    </div>
</div>

<!-- JavaScript for Auto-Filtering -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterForm = document.getElementById('filter-form');
        const inputs = filterForm.querySelectorAll('select, input');

        inputs.forEach(input => {
            input.addEventListener('change', function () {
                filterForm.submit(); // Automatically submit the form when a filter is changed
            });
        });
    });
</script>
@endsection