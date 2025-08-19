@echo off
title E-Ticket System - Network Server
color 0A

echo ========================================
echo    E-TICKET SYSTEM - NETWORK SERVER
echo ========================================
echo.

cd /d "%~dp0"

echo [INFO] Starting server for network access...

REM Test database connection
echo [INFO] Testing database connection...
php -r "try { $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=e-ticket', 'root', ''); echo 'Database e-ticket: Connected successfully\n'; } catch(Exception $e) { echo 'Database Error: ' . $e->getMessage() . '\n'; echo 'Please check: 1) MySQL is running 2) Database e-ticket exists 3) Credentials are correct\n'; }"

REM Clear cache (skip database-dependent commands)
php artisan config:clear
php artisan route:clear
php artisan view:clear

REM Cache configuration
php artisan config:cache

REM Clear session files manually
echo [INFO] Clearing session files...
if exist "storage\framework\sessions\*" del /q "storage\framework\sessions\*"

REM Create storage link if not exists
if not exist "public\storage" (
    php artisan storage:link
)

echo ========================================
echo   SERVER READY FOR NETWORK ACCESS
echo ========================================
echo.
echo PC Access: http://localhost:8000
echo Sunmi V2 Access: http://192.168.100.73:8000
echo.
echo [INFO] Using pre-built assets
echo [INFO] CSRF 419 error fixed
echo [INFO] Ready for Sunmi V2 printing
echo.
echo Press Ctrl+C to stop server
echo ========================================
echo.

php artisan serve --host=0.0.0.0 --port=8000

pause