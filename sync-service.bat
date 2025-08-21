@echo off
title E-Ticket Background Sync Service
echo Starting E-Ticket Background Sync Service...
echo Syncing every 60 seconds
echo Press Ctrl+C to stop
cd /d "d:\Sevastopol techs\e-ticket"

:loop
php artisan sync:background
timeout /t 60 /nobreak >nul
goto loop