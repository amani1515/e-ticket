@echo off
title Start E-Ticket Background Sync
echo 🚀 Starting E-Ticket Background Sync...
echo.

echo 🛑 Stopping any existing sync first...
schtasks /delete /tn "ETicketBackgroundSync" /f >nul 2>&1

echo ⚙️  Creating new Windows Task Scheduler...
schtasks /create /tn "ETicketBackgroundSync" /tr "php \"d:\Sevastopol techs\e-ticket\artisan\" sync:background" /sc minute /mo 1 /f

if %errorlevel% == 0 (
    echo ✅ Background sync STARTED successfully!
    echo 🔄 Syncing every minute automatically
    echo.
    echo To STOP background sync:
    echo   👉 Run "stop-background-sync.bat"
    echo.
    echo To check status:
    echo   schtasks /query /tn "ETicketBackgroundSync"
) else (
    echo ❌ Failed to start. Run as Administrator.
)

pause