<p align="center">
    <img src="public/tik1.png" alt="Sevastopol Technologies Logo" width="180">
</p>

# e-Ticket System

This project is a web-based E-Ticketing platform for bus management, ticket sales, and reporting. It is built with Laravel and includes roles for Admin, Ticketer, Mahberat, Traffic, CargoMan, HisabShum, and more.

---

## Getting Started

Follow these steps to set up and run the project on your local machine.

### 1. Extract the Project Files

- Unzip the provided project `.zip` file to your desired directory.

### 2. Import the Database

- Open your database management tool (e.g., phpMyAdmin, MySQL Workbench).
- Create a new database (e.g., `e_ticket`).
- Import the provided `.sql` file into this database.

### 3. Configure Environment Variables

- Copy `.env.example` to `.env` if not already present:
  ```
  cp .env.example .env
  ```
- Edit the `.env` file and set your database credentials (DB_DATABASE, DB_USERNAME, DB_PASSWORD) to match your local setup.

### 4. Install PHP Dependencies

```
composer install
```

### 5. Install Node.js Dependencies

```
npm install
```

### 6. Generate Application Key

```
php artisan key:generate
```

### 7. Build Frontend Assets

```
npm run build
```

### 8. Start the Development Server

```
php artisan serve
```

---

## Default Admin Credentials

- **Email:** admin@admin.com
- **Password:** password

> Only the admin can create accounts for other roles (Ticketer, Mahberat, Traffic, etc.).

---

## Demo & Testing

You can test the deployed project at:
[https://eticket.capitalltechs.com/](https://eticket.capitalltechs.com/)

---

## Repository

Source code is available at:
[https://github.com/amani1515/e-ticket](https://github.com/amani1515/e-ticket)

---

## Contact & Support

- Phone: +251 93 060 8000
- Telegram: [https://t.me/B011010000110000101100010](https://t.me/B011010000110000101100010)

For any information or support, feel free to contact us.

---

© 2025 E-Ticket System. All rights reserved.