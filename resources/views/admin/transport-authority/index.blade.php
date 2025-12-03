@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Transport Authority Data</h3>
                    <form method="GET" class="d-flex align-items-center">
                        <input type="date" name="date" value="{{ $date }}" class="form-control me-2" style="width: 200px;">
                        <button type="submit" class="btn btn-primary me-2">Filter</button>
                        <form method="POST" action="{{ route('admin.transport-authority.send') }}" class="d-inline">
                            @csrf
                            <input type="hidden" name="date" value="{{ $date }}">
                            <button type="submit" class="btn btn-success">Send to Authority</button>
                        </form>
                    </form>
                </div>

                @if(session('success'))
                    <div class="alert alert-success mx-3 mt-3">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger mx-3 mt-3">{{ session('error') }}</div>
                @endif

                <div class="card-body">
                    <!-- Tickets Section -->
                    <h5>Tickets ({{ $tickets->total() }})</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Passenger</th>
                                    <th>Phone</th>
                                    <th>Route</th>
                                    <th>Tariff</th>
                                    <th>Bus</th>
                                    <th>Mahberat</th>
                                    <th>Departure</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td>{{ $ticket->passenger_name }}</td>
                                    <td>{{ $ticket->phone_no }}</td>
                                    <td>{{ $ticket->destination->start_from }} → {{ $ticket->destination->destination_name }}</td>
                                    <td>{{ $ticket->tariff ?? $ticket->destination->tariff }} ብር</td>
                                    <td>{{ $ticket->bus->targa ?? $ticket->bus_id }}</td>
                                    <td>{{ $ticket->bus->mahberat->name ?? 'N/A' }}</td>
                                    <td>{{ $ticket->departure_datetime }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No tickets found for {{ $date }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $tickets->links() }}

                    <!-- Buses Section -->
                    <h5>Buses ({{ $buses->count() }})</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Targa</th>
                                    <th>Level</th>
                                    <th>Capacity</th>
                                    <th>Mahberat</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($buses as $bus)
                                <tr>
                                    <td>{{ $bus->id }}</td>
                                    <td>{{ $bus->targa }}</td>
                                    <td>
                                        <span class="badge bg-{{ $bus->level === 'level1' ? 'info' : ($bus->level === 'level2' ? 'warning' : 'success') }}">
                                            {{ ucfirst($bus->level) }}
                                        </span>
                                    </td>
                                    <td>{{ $bus->capacity }}</td>
                                    <td>{{ $bus->mahberat->name ?? 'N/A' }}</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Schedules Section -->
                    <h5>Schedules ({{ $schedules->count() }})</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Route</th>
                                    <th>Bus</th>
                                    <th>Mahberat</th>
                                    <th>Departure</th>
                                    <th>Available Seats</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->id }}</td>
                                    <td>{{ $schedule->destination->start_from }} → {{ $schedule->destination->destination_name }}</td>
                                    <td>{{ $schedule->bus->targa ?? $schedule->bus_id }}</td>
                                    <td>{{ $schedule->bus->mahberat->name ?? 'N/A' }}</td>
                                    <td>{{ $schedule->departure_datetime }}</td>
                                    <td>{{ $schedule->available_seats }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No schedules found for {{ $date }}</td>
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
@endsection