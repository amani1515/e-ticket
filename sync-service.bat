@echo off
title E-Ticket Background Sync Service
echo Starting E-Ticket Background Sync Service...
echo Syncing every 30 minutes (1800 seconds)
echo Press Ctrl+C to stop
cd /d "d:\project\e-ticket"

:loop
php artisan sync:background
timeout /t 1800 /nobreak >nul
goto loop