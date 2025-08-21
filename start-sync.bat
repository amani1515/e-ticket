@echo off
echo Starting E-Ticket Sync Service...
echo Press Ctrl+C to stop
cd /d "d:\Sevastopol techs\e-ticket"
php artisan sync:data --continuous
pause