@extends('admin.layout.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">All Cash Reports</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

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
</div>
@endsection
