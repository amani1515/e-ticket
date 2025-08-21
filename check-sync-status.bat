@echo off
title E-Ticket Sync Status
echo 🔍 Checking E-Ticket Background Sync Status...
echo.

echo 📋 Windows Task Scheduler Status:
schtasks /query /tn "ETicketBackgroundSync" 2>nul
if %errorlevel% == 0 (
    echo ✅ Background sync is RUNNING
) else (
    echo ❌ Background sync is STOPPED
)

echo.
echo 🔄 Testing sync connection...
cd /d "d:\Sevastopol techs\e-ticket"
php artisan sync:background

echo.
echo 📊 Recent sync activity (last 10 lines from log):
echo ----------------------------------------
tail -n 10 storage\logs\laravel.log 2>nul | findstr /i "sync"

echo.
echo ----------------------------------------
echo 💡 Commands:
echo   Start sync: setup-task-scheduler.bat
echo   Stop sync:  stop-background-sync.bat
echo.
pause