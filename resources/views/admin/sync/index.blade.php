@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-1"><i class="fas fa-sync-alt mr-2"></i>Data Synchronization</h2>
                            <p class="mb-0 opacity-75">Monitor and manage offline-online data synchronization</p>
                        </div>
                        <div class="text-right">
                            <div class="mb-2">
                                <span id="connection-status" class="badge badge-lg badge-{{ $status['online'] ? 'success' : 'danger' }} px-3 py-2">
                                    <i class="fas fa-{{ $status['online'] ? 'wifi' : 'wifi-slash' }} mr-1"></i>
                                    {{ $status['online'] ? 'Online' : 'Offline' }}
                                </span>
                            </div>
                            <div>
                                <button class="btn btn-light btn-lg" onclick="syncNow()" id="sync-btn">
                                    <i class="fas fa-sync mr-2"></i>Sync Now
                                </button>
                                <button class="btn btn-outline-light ml-2" onclick="retryFailedItems()">
                                    <i class="fas fa-redo mr-1"></i>Retry Failed
                                </button>
                                <button class="btn btn-outline-light ml-2" onclick="clearFailedItems()">
                                    <i class="fas fa-trash mr-1"></i>Clear Failed
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm h-100 stats-card" data-filter="all">
                <div class="card-body text-center">
                    <div class="bg-primary bg-gradient rounded-circle p-3 mx-auto mb-2" style="width: 60px; height: 60px;">
                        <i class="fas fa-database text-white fa-lg"></i>
                    </div>
                    <h3 class="mb-0 text-primary">{{ $summaryStats['total'] }}</h3>
                    <p class="text-muted mb-0 small">Total Items</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm h-100 stats-card" data-filter="pending">
                <div class="card-body text-center">
                    <div class="bg-warning bg-gradient rounded-circle p-3 mx-auto mb-2" style="width: 60px; height: 60px;">
                        <i class="fas fa-clock text-white fa-lg"></i>
                    </div>
                    <h3 class="mb-0 text-warning" id="pending-count">{{ $summaryStats['pending'] }}</h3>
                    <p class="text-muted mb-0 small">Pending</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm h-100 stats-card" data-filter="synced">
                <div class="card-body text-center">
                    <div class="bg-success bg-gradient rounded-circle p-3 mx-auto mb-2" style="width: 60px; height: 60px;">
                        <i class="fas fa-check-circle text-white fa-lg"></i>
                    </div>
                    <h3 class="mb-0 text-success">{{ $summaryStats['synced'] }}</h3>
                    <p class="text-muted mb-0 small">Synced</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm h-100 stats-card" data-filter="failed">
                <div class="card-body text-center">
                    <div class="bg-danger bg-gradient rounded-circle p-3 mx-auto mb-2" style="width: 60px; height: 60px;">
                        <i class="fas fa-exclamation-triangle text-white fa-lg"></i>
                    </div>
                    <h3 class="mb-0 text-danger" id="failed-count">{{ $summaryStats['failed'] }}</h3>
                    <p class="text-muted mb-0 small">Failed</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm h-100 stats-card" data-filter="today">
                <div class="card-body text-center">
                    <div class="bg-info bg-gradient rounded-circle p-3 mx-auto mb-2" style="width: 60px; height: 60px;">
                        <i class="fas fa-calendar-day text-white fa-lg"></i>
                    </div>
                    <h3 class="mb-0 text-info">{{ $summaryStats['today'] }}</h3>
                    <p class="text-muted mb-0 small">Today</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="bg-secondary bg-gradient rounded-circle p-3 mx-auto mb-2" style="width: 60px; height: 60px;">
                        <i class="fas fa-history text-white fa-lg"></i>
                    </div>
                    <h6 class="mb-0 text-secondary small">Last Sync</h6>
                    <p class="text-muted mb-0 small" id="last-sync">{{ $status['last_sync'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" id="filter-form" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label small text-muted">Status Filter</label>
                            <select name="status" class="form-select form-select-sm" onchange="applyFilters()">
                                <option value="all" {{ $statusFilter == 'all' ? 'selected' : '' }}>All Status</option>
                                <option value="pending" {{ $statusFilter == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="synced" {{ $statusFilter == 'synced' ? 'selected' : '' }}>Synced</option>
                                <option value="failed" {{ $statusFilter == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small text-muted">Date Filter</label>
                            <select name="date" class="form-select form-select-sm" onchange="applyFilters()">
                                <option value="all" {{ $dateFilter == 'all' ? 'selected' : '' }}>All Time</option>
                                <option value="today" {{ $dateFilter == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="week" {{ $dateFilter == 'week' ? 'selected' : '' }}>This Week</option>
                                <option value="month" {{ $dateFilter == 'month' ? 'selected' : '' }}>This Month</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small text-muted">Model Filter</label>
                            <select name="model" class="form-select form-select-sm" onchange="applyFilters()">
                                <option value="all" {{ $modelFilter == 'all' ? 'selected' : '' }}>All Models</option>
                                @foreach($availableModels as $model)
                                    <option value="{{ $model }}" {{ $modelFilter == $model ? 'selected' : '' }}>{{ $model }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small text-muted">Per Page</label>
                            <select name="per_page" class="form-select form-select-sm" onchange="applyFilters()">
                                <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20 per page</option>
                                <option value="30" {{ $perPage == 30 ? 'selected' : '' }}>30 per page</option>
                                <option value="40" {{ $perPage == 40 ? 'selected' : '' }}>40 per page</option>
                                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 per page</option>
                                <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100 per page</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sync Activity Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-list mr-2 text-primary"></i>Sync Activity</h5>
                        <div>
                            <span class="badge badge-info">{{ $syncData->total() }} total items</span>
                            <button class="btn btn-outline-primary btn-sm ml-2" onclick="refreshTable()">
                                <i class="fas fa-refresh mr-1"></i>Refresh
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0">UUID</th>
                                    <th class="border-0">Model</th>
                                    <th class="border-0">Action</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Attempts</th>
                                    <th class="border-0">Created</th>
                                    <th class="border-0">Last Attempt</th>
                                    <th class="border-0">Error</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($syncData as $item)
                                <tr class="{{ $item->synced ? '' : ($item->retry_count >= 3 ? 'table-danger' : 'table-warning') }}">
                                    <td>
                                        <code class="small bg-light px-2 py-1 rounded">{{ substr($item->model_uuid, 0, 20) }}...</code>
                                    </td>
                                    <td>
                                        <span class="badge badge-light">{{ class_basename($item->model_type) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $item->action === 'create' ? 'primary' : ($item->action === 'update' ? 'info' : 'danger') }}">
                                            <i class="fas fa-{{ $item->action === 'create' ? 'plus' : ($item->action === 'update' ? 'edit' : 'trash') }} mr-1"></i>
                                            {{ ucfirst($item->action) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($item->synced)
                                            <span class="badge badge-success"><i class="fas fa-check mr-1"></i>Synced</span>
                                        @elseif($item->retry_count >= 3)
                                            <span class="badge badge-danger"><i class="fas fa-times mr-1"></i>Failed</span>
                                        @else
                                            <span class="badge badge-warning"><i class="fas fa-clock mr-1"></i>Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $item->retry_count > 0 ? 'warning' : 'light' }}">
                                            {{ $item->retry_count }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $item->created_at->format('M d, Y H:i') }}</small>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $item->last_attempt ? $item->last_attempt->format('M d, H:i') : 'Never' }}</small>
                                    </td>
                                    <td>
                                        @if($item->error_message)
                                            <button class="btn btn-sm btn-outline-danger" onclick="showError('{{ addslashes($item->error_message) }}')" title="Click to view full error">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                Error
                                            </button>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-5">
                                        <i class="fas fa-inbox fa-3x mb-3 opacity-50"></i>
                                        <p class="mb-0">No sync activity found</p>
                                        <small>Try adjusting your filters or create some data to see sync activity</small>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Pagination -->
                @if($syncData->hasPages())
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing {{ $syncData->firstItem() }} to {{ $syncData->lastItem() }} of {{ $syncData->total() }} results
                        </div>
                        <div>
                            {{ $syncData->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.stats-card {
    cursor: pointer;
    transition: all 0.3s ease;
}
.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.table-hover tbody tr:hover {
    background-color: rgba(0,123,255,.075);
}
</style>

<script>
// SweetAlert Toast Configuration
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

// Apply Filters
function applyFilters() {
    document.getElementById('filter-form').submit();
}

// Stats Card Click Filters
document.querySelectorAll('.stats-card[data-filter]').forEach(card => {
    card.addEventListener('click', function() {
        const filter = this.dataset.filter;
        const url = new URL(window.location);
        
        if (filter === 'all') {
            url.searchParams.delete('status');
            url.searchParams.delete('date');
        } else if (['pending', 'synced', 'failed'].includes(filter)) {
            url.searchParams.set('status', filter);
            url.searchParams.delete('date');
        } else if (filter === 'today') {
            url.searchParams.set('date', 'today');
            url.searchParams.delete('status');
        }
        
        window.location.href = url.toString();
    });
});

// Sync Now Function
function syncNow() {
    const btn = document.getElementById('sync-btn');
    
    Swal.fire({
        title: 'Synchronizing Data',
        text: 'Please wait while we sync your data...',
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Syncing...';
        }
    });
    
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
            Swal.fire({
                title: 'Sync Successful!',
                text: data.message,
                icon: 'success',
                confirmButtonText: 'Great!',
                confirmButtonColor: '#28a745'
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                title: 'Sync Failed',
                text: data.message,
                icon: 'error',
                confirmButtonText: 'Try Again',
                confirmButtonColor: '#dc3545'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            title: 'Connection Error',
            text: 'Unable to connect to sync server: ' + error.message,
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#dc3545'
        });
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-sync mr-2"></i>Sync Now';
    });
}

// Show Error Details
function showError(errorMessage) {
    Swal.fire({
        title: 'Sync Error Details',
        text: errorMessage,
        icon: 'error',
        confirmButtonText: 'Close',
        confirmButtonColor: '#dc3545',
        width: '600px'
    });
}

// Retry Failed Items
function retryFailedItems() {
    Swal.fire({
        title: 'Retry Failed Items?',
        text: 'This will reset failed items and attempt to sync them again.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, retry them!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
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
                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    });
                    setTimeout(() => location.reload(), 1500);
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Failed to retry items'
                    });
                }
            })
            .catch(error => {
                Toast.fire({
                    icon: 'error',
                    title: 'Error: ' + error.message
                });
            });
        }
    });
}

// Clear Failed Items
function clearFailedItems() {
    Swal.fire({
        title: 'Clear Failed Items?',
        text: 'This will remove all failed sync items from the queue.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, clear them!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/admin/sync/clear-failed', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    });
                    setTimeout(() => location.reload(), 1500);
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Failed to clear items'
                    });
                }
            })
            .catch(error => {
                Toast.fire({
                    icon: 'error',
                    title: 'Error: ' + error.message
                });
            });
        }
    });
}

// Refresh Table
function refreshTable() {
    Toast.fire({
        icon: 'info',
        title: 'Refreshing sync data...'
    });
    
    setTimeout(() => {
        location.reload();
    }, 1000);
}

// Auto-refresh status every 30 seconds
setInterval(() => {
    fetch('/admin/sync/status')
        .then(response => response.json())
        .then(data => {
            // Update connection status
            const statusBadge = document.getElementById('connection-status');
            statusBadge.className = 'badge badge-lg badge-' + (data.online ? 'success' : 'danger') + ' px-3 py-2';
            statusBadge.innerHTML = '<i class="fas fa-' + (data.online ? 'wifi' : 'wifi-slash') + ' mr-1"></i>' + (data.online ? 'Online' : 'Offline');
            
            // Update counts
            document.getElementById('pending-count').textContent = data.pending;
            document.getElementById('failed-count').textContent = data.failed;
            document.getElementById('last-sync').textContent = data.last_sync;
            
            // Show toast if status changed
            if (data.online && !window.wasOnline) {
                Toast.fire({
                    icon: 'success',
                    title: 'Connection restored!'
                });
            } else if (!data.online && window.wasOnline) {
                Toast.fire({
                    icon: 'warning',
                    title: 'Connection lost'
                });
            }
            window.wasOnline = data.online;
        })
        .catch(error => {
            console.error('Status check failed:', error);
        });
}, 30000);

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tooltips if available
    if (typeof $!== 'undefined' && $.fn.tooltip) {
        $('[data-toggle="tooltip"]').tooltip();
    }
    
    // Set initial online status
    window.wasOnline = {{ $status['online'] ? 'true' : 'false' }};
    
    @if($summaryStats['pending'] > 0)
        Toast.fire({
            icon: 'info',
            title: '{{ $summaryStats["pending"] }} items waiting to sync'
        });
    @endif
});
</script>
@endsection