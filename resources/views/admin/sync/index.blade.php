@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Data Synchronization</h3>
                    <div>
                        <span class="badge badge-{{ $status['online'] ? 'success' : 'danger' }}">
                            {{ $status['online'] ? 'Online' : 'Offline' }}
                        </span>
                        <button class="btn btn-primary btn-sm ml-2" onclick="syncNow()">
                            <i class="fas fa-sync"></i> Sync Now
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h4>{{ $status['pending'] }}</h4>
                                    <p>Pending Sync</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <h4>{{ $status['failed'] }}</h4>
                                    <p>Failed Items</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-secondary text-white">
                                <div class="card-body">
                                    <h6>Last Sync Attempt</h6>
                                    <p>{{ $status['last_sync'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5>Recent Sync Activity</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>UUID</th>
                                    <th>Model</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                    <th>Attempts</th>
                                    <th>Created</th>
                                    <th>Last Attempt</th>
                                    <th>Error</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentSync ?? [] as $item)
                                <tr class="{{ $item->synced ? '' : ($item->retry_count >= 3 ? 'table-danger' : 'table-warning') }}">
                                    <td>
                                        <code class="small">{{ substr($item->model_uuid, 0, 20) }}...</code>
                                    </td>
                                    <td>{{ class_basename($item->model_type) }}</td>
                                    <td>
                                        <span class="badge badge-{{ $item->action === 'create' ? 'primary' : ($item->action === 'update' ? 'info' : 'danger') }}">
                                            {{ ucfirst($item->action) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($item->synced)
                                            <span class="badge badge-success">✓ Synced</span>
                                        @elseif($item->retry_count >= 3)
                                            <span class="badge badge-danger">✗ Failed</span>
                                        @else
                                            <span class="badge badge-warning">⏳ Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $item->retry_count > 0 ? 'warning' : 'light' }}">
                                            {{ $item->retry_count }}
                                        </span>
                                    </td>
                                    <td>{{ $item->created_at->format('M d, H:i') }}</td>
                                    <td>{{ $item->last_attempt ? $item->last_attempt->format('M d, H:i') : 'Never' }}</td>
                                    <td>
                                        @if($item->error_message)
                                            <span class="text-danger small" title="{{ $item->error_message }}">
                                                {{ Str::limit($item->error_message, 30) }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        No sync activity yet
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function syncNow() {
    const btn = event.target;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Syncing...';
    
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
            alert(data.message);
            location.reload();
        } else {
            alert('Sync failed: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-sync"></i> Sync Now';
    });
}

// Auto-refresh status every 30 seconds
setInterval(() => {
    fetch('/admin/sync/status')
        .then(response => response.json())
        .then(data => {
            document.querySelector('.badge').className = 
                'badge badge-' + (data.online ? 'success' : 'danger');
            document.querySelector('.badge').textContent = 
                data.online ? 'Online' : 'Offline';
        });
}, 30000);
</script>
@endsection