@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const destinationLabels = {!! json_encode($destinationLabels) !!};
    const passengerCounts = {!! json_encode($passengerCounts) !!};

    // Generate distinct colors for each bar
    const backgroundColors = destinationLabels.map((_, i) => {
        const colors = [
            '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6',
            '#6366F1', '#EC4899', '#14B8A6', '#F97316', '#0EA5E9'
        ];
        return colors[i % colors.length];
    });

    const ctx = document.getElementById('passengerChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: destinationLabels,
            datasets: [{
                label: 'Passengers',
                data: passengerCounts,
                backgroundColor: backgroundColors,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#4B5563'
                    }
                },
                x: {
                    ticks: {
                        color: '#4B5563'
                    }
                }
            }
        }
    });
</script>
@endsection
