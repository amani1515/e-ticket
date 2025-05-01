<table>
    <thead>
        <tr>
            <th>Passenger</th>
            <th>Gender</th>
            <th>Destination</th>
            <th>Age Status</th>
            <th>Bus ID</th>
            <th>Tariff</th>
            <th>Tax</th>
            <th>Service Fee</th>
            <th>Total Price</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tickets as $ticket)
            <tr>
                <td>{{ $ticket->passenger_name }}</td>
                <td>{{ $ticket->gender }}</td>
                <td>{{ $ticket->destination->destination_name ?? 'N/A' }}</td>
                <td>{{ $ticket->age_status }}</td>
                <td>{{ $ticket->bus_id }}</td>
                <td>{{ $ticket->destination->tariff }}</td>
                <td>{{ $ticket->destination->tax }}</td>
                <td>{{ $ticket->destination->service_fee }}</td>
                <td>{{ ($ticket->destination->tariff ?? 0) + ($ticket->destination->tax ?? 0) + ($ticket->destination->service_fee ?? 0) }}</td>
                <td>{{ $ticket->created_at->format('Y-m-d') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<h3>Summary</h3>
<ul>
    <li>Total Tariff: {{ $summaries['total_tariff'] }} ETB</li>
    <li>Total Tax: {{ $summaries['total_tax'] }} ETB</li>
    <li>Total Service Fee: {{ $summaries['total_service_fee'] }} ETB</li>
    <li>Total Male: {{ $summaries['male'] }}</li>
    <li>Total Female: {{ $summaries['female'] }}</li>
    <li>Total Adult: {{ $summaries['adult'] }}</li>
    <li>Total Baby: {{ $summaries['baby'] }}</li>
    <li>Total Senior: {{ $summaries['senior'] }}</li>
</ul>

<h3>Summary by Destination</h3>
<ul>
    @foreach($summaries['by_destination'] as $destination => $count)
        <li>{{ $destination }}: {{ $count }} passengers</li>
    @endforeach
</ul>
