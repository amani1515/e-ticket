<p align="center">
    <img src="public/tik1.png" alt="Sevastopol Technologies Logo" width="180">
</p>

# e-Ticket System

This project is a bus ticketing and schedule management system built with Laravel.  
It allows bus operators, ticketers, and hisab shum (accounting) users to manage bus schedules, ticket sales, payments, and reporting.

## Features

- Bus schedule creation and management
- Unique schedule ID generation for barcode use
- Ticket sales and confirmation
- Payment tracking and reporting
- Departed certificate generation with printable A4 and barcode
- Role-based access for ticketer, hisab shum, and admin
- Filterable and paginated reports by date, bus, destination, and user

## Getting Started

1. Clone the repository.
2. Run `composer install` and `npm install`.
3. Copy `.env.example` to `.env` and set your database credentials.
4. Run `php artisan migrate` to set up the database.
5. Run `php artisan serve` to start the development server.

## Usage

- Log in as a ticketer to create and pay for schedules.
- Log in as a hisab shum user to approve and print departed certificates.
- Use the sidebar to access reports and filter data as needed.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

*Developed by Sevastopol Technologies*