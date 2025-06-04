@extends('admin.layout.app')

@section('content')
<div class="p-6 bg-white rounded shadow-md">

    <h1 class="text-2xl font-bold mb-6">All Transactions</h1>

    <form method="GET" action="{{ route('admin.reports.transactions') }}" class="mb-6 flex flex-wrap gap-4 items-end">

        {{-- Level filter --}}
        <div>
            <label for="level" class="block mb-1 font-semibold">Level</label>
            <select name="level" id="level" class="border px-3 py-2 rounded">
                <option value="">-- All Levels --</option>
                <option value="level1" {{ (isset($filters['level']) && $filters['level'] == 'level1') ? 'selected' : '' }}>Level 1</option>
                <option value="level2" {{ (isset($filters['level']) && $filters['level'] == 'level2') ? 'selected' : '' }}>Level 2</option>
                <option value="level3" {{ (isset($filters['level']) && $filters['level'] == 'level3') ? 'selected' : '' }}>Level 3</option>
            </select>
        </div>

        {{-- Predefined date filters --}}
        <div>
            <label for="date_filter" class="block mb-1 font-semibold">Date Filter</label>
            <select name="date_filter" id="date_filter" class="border px-3 py-2 rounded">
                <option value="">-- Select --</option>
                <option value="today" {{ (isset($filters['date_filter']) && $filters['date_filter'] == 'today') ? 'selected' : '' }}>Today</option>
                <option value="thisweek" {{ (isset($filters['date_filter']) && $filters['date_filter'] == 'thisweek') ? 'selected' : '' }}>This Week</option>
                <option value="thismonth" {{ (isset($filters['date_filter']) && $filters['date_filter'] == 'thismonth') ? 'selected' : '' }}>This Month</option>
                <option value="thisyear" {{ (isset($filters['date_filter']) && $filters['date_filter'] == 'thisyear') ? 'selected' : '' }}>This Year</option>
            </select>
        </div>

        {{-- Custom date from --}}
        <div>
            <label for="date_from" class="block mb-1 font-semibold">From</label>
            <input type="date" name="date_from" id="date_from" value="{{ $filters['date_from'] ?? '' }}" class="border px-3 py-2 rounded" />
        </div>

        {{-- Custom date to --}}
        <div>
            <label for="date_to" class="block mb-1 font-semibold">To</label>
            <input type="date" name="date_to" id="date_to" value="{{ $filters['date_to'] ?? '' }}" class="border px-3 py-2 rounded" />
        </div>

        <div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Filter</button>
            <a href="{{ route('admin.reports.transactions') }}" class="ml-2 px-4 py-2 rounded border border-gray-300 hover:bg-gray-100">Reset</a>
        </div>
    </form>
    </form>

{{-- Insert card here --}}
<div class="mb-6">
    <div class="bg-green-100 text-green-800 border border-green-300 px-6 py-4 rounded shadow inline-block">
        <h2 class="text-lg font-semibold">Total Amount</h2>
        <p class="text-2xl font-bold mt-1">ETB {{ number_format($totalAmount, 2) }}</p>
    </div>
</div>


    @if($transactions->count())
        <table class="min-w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2">Transaction Ref</th>
                    <th class="border border-gray-300 px-4 py-2">Amount</th>
                    <th class="border border-gray-300 px-4 py-2">Currency</th>
                    <th class="border border-gray-300 px-4 py-2">Payment Method</th>
                    <th class="border border-gray-300 px-4 py-2">Level</th>
                    <th class="border border-gray-300 px-4 py-2">Schedule ID</th>
                    <th class="border border-gray-300 px-4 py-2">Status</th>
                    <th class="border border-gray-300 px-4 py-2">Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr class="hover:bg-yellow-50">
                    <td class="border border-gray-300 px-4 py-2">{{ $transaction->tx_ref }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ number_format($transaction->amount, 2) }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ strtoupper($transaction->currency) }}</td>
                    <td class="border border-gray-300 px-4 py-2 capitalize">{{ $transaction->payment_method }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $transaction->level ?? '-' }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $transaction->schedule_id ?? '-' }}</td>
                    <td class="border border-gray-300 px-4 py-2 capitalize">{{ $transaction->status }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $transactions->links() }}
        </div>

    @else
        <p>No transactions found.</p>
    @endif
</div>
@endsection
