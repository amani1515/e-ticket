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

    <!-- Beautiful Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card border-0 shadow-lg h-100 stats-card gradient-card-1" data-filter="all">
                <div class="card-body text-center text-white position-relative">
                    <div class="icon-circle mb-3">
                        <i class="fas fa-database fa-2x"></i>
                    </div>
                    <h2 class="mb-1 font-weight-bold">{{ $summaryStats['total'] }}</h2>
                    <p class="mb-0 opacity-75">Total Items</p>
                    <div class="card-glow"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card border-0 shadow-lg h-100 stats-card gradient-card-2" data-filter="pending">
                <div class="card-body text-center text-white position-relative">
                    <div class="icon-circle mb-3">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                    <h2 class="mb-1 font-weight-bold" id="pending-count">{{ $summaryStats['pending'] }}</h2>
                    <p class="mb-0 opacity-75">Pending</p>
                    <div class="card-glow"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card border-0 shadow-lg h-100 stats-card gradient-card-3" data-filter="synced">
                <div class="card-body text-center text-white position-relative">
                    <div class="icon-circle mb-3">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                    <h2 class="mb-1 font-weight-bold">{{ $summaryStats['synced'] }}</h2>
                    <p class="mb-0 opacity-75">Synced</p>
                    <div class="card-glow"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card border-0 shadow-lg h-100 stats-card gradient-card-4" data-filter="failed">
                <div class="card-body text-center text-white position-relative">
                    <div class="icon-circle mb-3">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                    <h2 class="mb-1 font-weight-bold" id="failed-count">{{ $summaryStats['failed'] }}</h2>
                    <p class="mb-0 opacity-75">Failed</p>
                    <div class="card-glow"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card border-0 shadow-lg h-100 stats-card gradient-card-5" data-filter="today">
                <div class="card-body text-center text-white position-relative">
                    <div class="icon-circle mb-3">
                        <i class="fas fa-calendar-day fa-2x"></i>
                    </div>
                    <h2 class="mb-1 font-weight-bold">{{ $summaryStats['today'] }}</h2>
                    <p class="mb-0 opacity-75">Today</p>
                    <div class="card-glow"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card border-0 shadow-lg h-100 gradient-card-6">
                <div class="card-body text-center text-white position-relative">
                    <div class="icon-circle mb-3">
                        <i class="fas fa-history fa-2x"></i>
                    </div>
                    <h6 class="mb-1 font-weight-bold">Last Sync</h6>
                    <p class="mb-0 opacity-75 small" id="last-sync">{{ $status['last_sync'] }}</p>
                    <div class="card-glow"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Filters & Auto-Sync Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg filter-card">
                <div class="card-header bg-gradient-light border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 text-primary"><i class="fas fa-filter mr-2"></i>Filters & Settings</h6>
                        <div class="d-flex align-items-center">
                            <span class="text-muted small mr-3">Auto Sync:</span>
                            <div class="custom-control custom-switch mr-3">
                                <input type="checkbox" class="custom-control-input" id="autoSyncToggle">
                                <label class="custom-control-label" for="autoSyncToggle"></label>
                            </div>
                            <select id="autoSyncInterval" class="form-select form-select-sm" style="width: 120px;" disabled>
                                <option value="10">10 sec</option>
                                <option value="30">30 sec</option>
                                <option value="60">1 min</option>
                                <option value="180" selected>3 min</option>
                                <option value="300">5 min</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" id="filter-form" class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label small text-muted font-weight-bold">Status Filter</label>
                            <select name="status" class="form-select form-select-sm custom-select" onchange="applyFilters()">
                                <option value="all" {{ $statusFilter == 'all' ? 'selected' : '' }}>🔄 All Status</option>
                                <option value="pending" {{ $statusFilter == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="synced" {{ $statusFilter == 'synced' ? 'selected' : '' }}>✅ Synced</option>
                                <option value="failed" {{ $statusFilter == 'failed' ? 'selected' : '' }}>❌ Failed</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small text-muted font-weight-bold">Date Filter</label>
                            <select name="date" class="form-select form-select-sm custom-select" onchange="applyFilters()">
                                <option value="all" {{ $dateFilter == 'all' ? 'selected' : '' }}>📅 All Time</option>
                                <option value="today" {{ $dateFilter == 'today' ? 'selected' : '' }}>📆 Today</option>
                                <option value="week" {{ $dateFilter == 'week' ? 'selected' : '' }}>📊 This Week</option>
                                <option value="month" {{ $dateFilter == 'month' ? 'selected' : '' }}>📈 This Month</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small text-muted font-weight-bold">Model Filter</label>
                            <select name="model" class="form-select form-select-sm custom-select" onchange="applyFilters()">
                                <option value="all" {{ $modelFilter == 'all' ? 'selected' : '' }}>🗂️ All Models</option>
                                @foreach($availableModels as $model)
                                    <option value="{{ $model }}" {{ $modelFilter == $model ? 'selected' : '' }}>📋 {{ $model }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small text-muted font-weight-bold">Per Page</label>
                            <select name="per_page" class="form-select form-select-sm custom-select" onchange="applyFilters()">
                                <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>📄 20 per page</option>
                                <option value="30" {{ $perPage == 30 ? 'selected' : '' }}>📄 30 per page</option>
                                <option value="40" {{ $perPage == 40 ? 'selected' : '' }}>📄 40 per page</option>
                                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>📄 50 per page</option>
                                <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>📄 100 per page</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted font-weight-bold">Quick Actions</label>
                            <div class="btn-group w-100" role="group">
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="refreshTable()">
                                    <i class="fas fa-refresh mr-1"></i>Refresh
                                </button>
                                <button type="button" class="btn btn-outline-success btn-sm" onclick="syncNow()">
                                    <i class="fas fa-sync mr-1"></i>Sync
                                </button>
                                <button type="button" class="btn btn-outline-warning btn-sm" onclick="retryFailedItems()">
                                    <i class="fas fa-redo mr-1"></i>Retry
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="clearFailedItems()">
                                    <i class="fas fa-trash mr-1"></i>Clear
                                </button>
                            </div>
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
                
                <!-- Beautiful Pagination -->
                @if($syncData->hasPages())
                <div class="card-footer bg-gradient-light border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            <i class="fas fa-info-circle mr-1"></i>
                            Showing <span class="font-weight-bold text-primary">{{ $syncData->firstItem() }}</span> to 
                            <span class="font-weight-bold text-primary">{{ $syncData->lastItem() }}</span> of 
                            <span class="font-weight-bold text-primary">{{ $syncData->total() }}</span> results
                        </div>
                        <div class="pagination-wrapper">
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
/* Beautiful Gradient Cards */
.gradient-card-1 {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.gradient-card-2 {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}
.gradient-card-3 {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}
.gradient-card-4 {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}
.gradient-card-5 {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}
.gradient-card-6 {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
}

.stats-card {
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border-radius: 15px;
    overflow: hidden;
}

.stats-card:hover {
    transform: translateY(-10px) scale(1.05);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2) !important;
}

.icon-circle {
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.card-glow {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
    transform: translateX(-100%);
    transition: transform 0.6s;
}

.stats-card:hover .card-glow {
    transform: translateX(100%);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-light {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.filter-card {
    border-radius: 15px;
    overflow: hidden;
}

.custom-select {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.custom-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.table-hover tbody tr:hover {
    background: linear-gradient(90deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    transform: scale(1.01);
    transition: all 0.3s ease;
}

.pagination-wrapper .page-link {
    border-radius: 10px;
    margin: 0 2px;
    border: none;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    transition: all 0.3s ease;
}

.pagination-wrapper .page-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.pagination-wrapper .page-item.active .page-link {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    border: none;
}

.custom-control-label::before {
    border-radius: 10px;
    border: 2px solid #667eea;
}

.custom-control-input:checked ~ .custom-control-label::before {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7); }
    70% { box-shadow: 0 0 0 10px rgba(102, 126, 234, 0); }
    100% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0); }
}

.auto-sync-active {
    animation: pulse 2s infinite;
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

// Auto-Sync Functionality
let autoSyncInterval = null;
let autoSyncEnabled = false;

function toggleAutoSync() {
    const toggle = document.getElementById('autoSyncToggle');
    const intervalSelect = document.getElementById('autoSyncInterval');
    
    autoSyncEnabled = toggle.checked;
    intervalSelect.disabled = !autoSyncEnabled;
    
    if (autoSyncEnabled) {
        startAutoSync();
        document.querySelector('.custom-control-label').classList.add('auto-sync-active');
        Toast.fire({
            icon: 'success',
            title: 'Auto-sync enabled!'
        });
    } else {
        stopAutoSync();
        document.querySelector('.custom-control-label').classList.remove('auto-sync-active');
        Toast.fire({
            icon: 'info',
            title: 'Auto-sync disabled'
        });
    }
    
    // Save preference
    localStorage.setItem('autoSyncEnabled', autoSyncEnabled);
    localStorage.setItem('autoSyncInterval', intervalSelect.value);
}

function startAutoSync() {
    stopAutoSync(); // Clear any existing interval
    
    const intervalSeconds = parseInt(document.getElementById('autoSyncInterval').value);
    
    autoSyncInterval = setInterval(() => {
        if (autoSyncEnabled) {
            // Silent sync without showing loading dialog
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
                    // Update counts without full page reload
                    updateSyncCounts();
                    
                    // Show subtle notification
                    Toast.fire({
                        icon: 'success',
                        title: 'Auto-sync completed',
                        timer: 1500
                    });
                }
            })
            .catch(error => {
                console.error('Auto-sync failed:', error);
            });
        }
    }, intervalSeconds * 1000);
}

function stopAutoSync() {
    if (autoSyncInterval) {
        clearInterval(autoSyncInterval);
        autoSyncInterval = null;
    }
}

function updateAutoSyncInterval() {
    if (autoSyncEnabled) {
        startAutoSync(); // Restart with new interval
        
        const intervalSeconds = parseInt(document.getElementById('autoSyncInterval').value);
        Toast.fire({
            icon: 'info',
            title: `Auto-sync interval updated to ${intervalSeconds}s`
        });
        
        localStorage.setItem('autoSyncInterval', intervalSeconds);
    }
}

function updateSyncCounts() {
    fetch('/admin/sync/status')
        .then(response => response.json())
        .then(data => {
            document.getElementById('pending-count').textContent = data.pending;
            document.getElementById('failed-count').textContent = data.failed;
            document.getElementById('last-sync').textContent = data.last_sync;
        })
        .catch(error => {
            console.error('Failed to update counts:', error);
        });
}

// Initialize tooltips and auto-sync
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tooltips if available
    if (typeof $ !== 'undefined' && $.fn.tooltip) {
        $('[data-toggle="tooltip"]').tooltip();
    }
    
    // Set initial online status
    window.wasOnline = {{ $status['online'] ? 'true' : 'false' }};
    
    // Restore auto-sync preferences
    const savedAutoSync = localStorage.getItem('autoSyncEnabled') === 'true';
    const savedInterval = localStorage.getItem('autoSyncInterval') || '180';
    
    document.getElementById('autoSyncToggle').checked = savedAutoSync;
    document.getElementById('autoSyncInterval').value = savedInterval;
    
    if (savedAutoSync) {
        toggleAutoSync();
    }
    
    // Add event listeners
    document.getElementById('autoSyncToggle').addEventListener('change', toggleAutoSync);
    document.getElementById('autoSyncInterval').addEventListener('change', updateAutoSyncInterval);
    
    @if($summaryStats['pending'] > 0)
        Toast.fire({
            icon: 'info',
            title: '{{ $summaryStats["pending"] }} items waiting to sync'
        });
    @endif
    
    // Add card hover effects
    document.querySelectorAll('.stats-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.05)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});
</script>
@endsection