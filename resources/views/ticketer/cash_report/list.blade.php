@extends('ticketer.layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">My Cash Reports</h1>
                    <p class="text-gray-600 mt-1">View your submitted cash reports</p>
                </div>
                <a href="{{ route('ticketer.cash-report.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Submit New Report
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-700">Filter by:</span>
                <div class="flex space-x-2">
                    <a href="{{ route('ticketer.cash-report.list') }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium {{ $filter === 'all' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        All Reports
                    </a>
                    <a href="{{ route('ticketer.cash-report.list', ['filter' => 'today']) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium {{ $filter === 'today' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        Today
                    </a>
                    <a href="{{ route('ticketer.cash-report.list', ['filter' => 'week']) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium {{ $filter === 'week' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        This Week
                    </a>
                </div>
            </div>
        </div>

        <!-- Reports List -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            @if($reports->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tax</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service Fee</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($reports as $report)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($report->report_date)->format('M d, Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($report->report_date)->format('l') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-green-600">
                                        {{ number_format($report->total_amount, 2) }} Birr
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ number_format($report->tax, 2) }} Birr
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ number_format($report->service_fee, 2) }} Birr
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($report->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                            </svg>
                                            Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Received
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $report->submitted_at ? \Carbon\Carbon::parse($report->submitted_at)->format('M d, Y H:i') : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($report->status === 'received')
                                        <a href="{{ route('ticketer.cash-report.receipt', $report->id) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                            </svg>
                                            Print
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400">Print available when received</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($reports->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 flex justify-between sm:hidden">
                            @if($reports->onFirstPage())
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">Previous</span>
                            @else
                                <a href="{{ $reports->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Previous</a>
                            @endif
                            
                            @if($reports->hasMorePages())
                                <a href="{{ $reports->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Next</a>
                            @else
                                <span class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">Next</span>
                            @endif
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing {{ $reports->firstItem() }} to {{ $reports->lastItem() }} of {{ $reports->total() }} results
                                </p>
                            </div>
                            <div>
                                {{ $reports->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No reports found</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @if($filter === 'today')
                            You haven't submitted any reports today.
                        @elseif($filter === 'week')
                            You haven't submitted any reports this week.
                        @else
                            You haven't submitted any cash reports yet.
                        @endif
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('ticketer.cash-report.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Submit Your First Report
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Summary Stats -->
        @if($reports->total() > 0)
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Reports</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $reports->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Amount</p>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($reports->getCollection()->sum('total_amount'), 2) }} Birr</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Pending</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $reports->getCollection()->where('status', 'pending')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@section('scripts')
<script>
function printReceipt(reportId) {
    // Find the report data
    const reports = @json($reports);
    const report = reports.find(r => r.id === reportId);
    
    if (!report) {
        alert('Report not found');
        return;
    }
    
    // Format dates
    const reportDate = new Date(report.report_date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short', 
        day: 'numeric'
    });
    
    const submittedDate = report.submitted_at ? 
        new Date(report.submitted_at).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        }) : 'N/A';
    
    // Create receipt content for 58mm POS printer
    const receiptContent = `
        <div style="text-align: center; margin-bottom: 10px;">
            <strong>E-TICKET SYSTEM</strong><br>
            <small>Cash Report Receipt</small>
        </div>
        
        <div style="text-align: center; margin: 10px 0;">
            <strong style="font-size: 14px;">CONGRATULATIONS!</strong><br>
            <small>Your cash report has been</small><br>
            <strong>CONFIRMED</strong>
        </div>
        
        <div style="border-top: 1px dashed #000; margin: 8px 0; padding-top: 8px;">
            <strong>REPORT DETAILS</strong><br>
            Report Date: ${reportDate}<br>
            Status: ${report.status.toUpperCase()}<br>
            Submitted: ${submittedDate}
        </div>
        
        <div style="border-top: 1px dashed #000; margin: 8px 0; padding-top: 8px;">
            <strong>FINANCIAL SUMMARY</strong><br>
            // Total Amount: ${parseFloat(report.total_amount).toFixed(2)} Birr<br>
            // Tax Amount: ${parseFloat(report.tax).toFixed(2)} Birr<br>
            Collected Service Fee: ${parseFloat(report.service_fee).toFixed(2)} Birr
        </div>
        
        <div style="border-top: 1px dashed #000; margin: 8px 0; padding-top: 8px;">
            <strong>TICKETER INFO</strong><br>
            Name: {{ auth()->user()->name }}<br>
            ID: {{ auth()->user()->id }}
        </div>
        
        <div style="text-align: center; margin-top: 10px; font-size: 10px;">
            Thank you for your service!<br>
            Generated: ${new Date().toLocaleString()}
        </div>
        
        <div style="text-align: center; margin-top: 8px; border-top: 1px dashed #000; padding-top: 8px;">
            <small>Sevastopol technologies PLC © 2025</small>
        </div>
    `;
    
    // Create print window
    const printWindow = window.open('', '_blank', 'width=300,height=600');
    
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Cash Report Receipt</title>
            <style>
                @media print {
                    @page {
                        size: 58mm auto;
                        margin: 2mm;
                    }
                    body {
                        margin: 0;
                        padding: 0;
                    }
                }
                body {
                    font-family: 'Courier New', monospace;
                    font-size: 12px;
                    line-height: 1.3;
                    width: 58mm;
                    margin: 0;
                    padding: 2mm;
                    color: #000;
                }
                strong {
                    font-weight: bold;
                }
                small {
                    font-size: 10px;
                }
            </style>
        </head>
        <body>
            ${receiptContent}
        </body>
        </html>
    `);
    
    printWindow.document.close();
    
    // Wait for content to load then print
    setTimeout(() => {
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    }, 500);
}
</script>
@endsection