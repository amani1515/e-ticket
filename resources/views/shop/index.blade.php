<!DOCTYPE html>
<html>

<head>
    <title>Ticket Shop</title>
    <!-- Include any necessary CSS or JS files here -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        /* Basic CSS styles for the page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 10px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <header>
        <!-- Include your navigation or header content here -->
    </header>

    <main>
        <div class="container">
            <h1>Ticket Shop</h1>

            <form action="{{ route('shop.tickets.store') }}" method="POST" id="payment-form">
                @csrf
                <div class="form-group">
                    <label for="destination">Destination</label>
                    <select name="destination" id="destination" class="form-control">
                        @foreach ($destinations as $destination)
                            <option value="{{ $destination->id }}">{{ $destination->destination_name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="destination_id" id="destination-id">
                </div>

                <div class="form-group">
                    <label for="car">Car</label>
                    <select name="car" id="car" class="form-control">
                        @foreach (collect($schedules) as $schedule)
                            <option value="{{ $schedule->bus->id }}">{{ $schedule->bus->targa }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="car_id" id="car-id">
                </div>

                <div class="form-group">
                    <label for="passenger_name">Passenger Name</label>
                    <input type="text" name="passenger_name" id="passenger_name" class="form-control">
                </div>

                <!-- ... rest of your code ... -->
            </form>

            <script>
                // JavaScript code for handling search functionality
                $(function() {
                    var schedules = <?php echo json_encode($schedules); ?>;

                    $('#destination').autocomplete({
                        source: destinations.map(function(destination) {
                            return {
                                label: destination.destination_name,
                                value: destination.id
                            };
                        }),
                        select: function(event, ui) {
                            $('#destination-id').val(ui.item.value);

                            // Update the car options based on the selected destination
                            var filteredSchedules = schedules.filter(function(schedule) {
                                return schedule.destination_id === ui.item.value;
                            });

                            $('#car').empty();
                            filteredSchedules.forEach(function(schedule) {
                                if (schedule.bus) {
                                    $('#car').append('<option value="' + schedule.bus.id + '">' +
                                        schedule.bus.targa + '</option>');
                                }
                            });
                        }
                    });
                });
            </script>
            
        </div>
    </main>

    <footer>
        <!-- Include your footer content here -->
    </footer>
</body>

</html>