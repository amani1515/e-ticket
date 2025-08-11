@echo off
echo ========================================
echo    E-Ticket Local Server Startup
echo ========================================
echo.

echo Starting Laravel Local Server...
echo Server will be accessible at:
echo - Local: http://localhost:8000
echo - Network: http://YOUR_IP:8000
echo.
echo Press Ctrl+C to stop the server
echo ========================================
echo.

php artisan serve --host=0.0.0.0 --port=8000