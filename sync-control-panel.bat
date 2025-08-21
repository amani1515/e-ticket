@echo off
title E-Ticket Sync Control Panel
:menu
cls
echo ╔══════════════════════════════════════════════════════════════╗
echo ║                E-TICKET SYNC CONTROL PANEL                  ║
echo ╚══════════════════════════════════════════════════════════════╝
echo.

echo Checking current status...
schtasks /query /tn "ETicketBackgroundSync" >nul 2>&1
if %errorlevel% == 0 (
    echo 🟢 Status: BACKGROUND SYNC IS RUNNING
    echo    ├─ Syncing every 1 minute automatically
    echo    └─ No manual intervention needed
) else (
    echo 🔴 Status: BACKGROUND SYNC IS STOPPED
    echo    ├─ Data will NOT sync automatically
    echo    └─ Manual sync only
)

echo.
echo ╔══════════════════════════════════════════════════════════════╗
echo ║                        OPTIONS                               ║
echo ╚══════════════════════════════════════════════════════════════╝
echo.
echo [1] 🚀 START Background Sync (every 1 minute)
echo [2] 🛑 STOP Background Sync  
echo [3] 🔄 Manual Sync Now
echo [4] 📊 Check Status & Logs
echo [5] ❌ Exit
echo.
set /p choice="Enter your choice (1-5): "

if "%choice%"=="1" goto start_sync
if "%choice%"=="2" goto stop_sync  
if "%choice%"=="3" goto manual_sync
if "%choice%"=="4" goto check_status
if "%choice%"=="5" goto exit
goto menu

:start_sync
echo.
echo 🚀 Starting background sync...
schtasks /delete /tn "ETicketBackgroundSync" /f >nul 2>&1
schtasks /create /tn "ETicketBackgroundSync" /tr "php \"d:\Sevastopol techs\e-ticket\artisan\" sync:background" /sc minute /mo 1 /f
if %errorlevel% == 0 (
    echo ✅ Background sync STARTED successfully!
) else (
    echo ❌ Failed to start. Run as Administrator.
)
pause
goto menu

:stop_sync
echo.
echo 🛑 Stopping background sync...
schtasks /delete /tn "ETicketBackgroundSync" /f >nul 2>&1
taskkill /f /im php.exe /fi "WINDOWTITLE eq *sync*" >nul 2>&1
echo ✅ Background sync STOPPED completely!
pause
goto menu

:manual_sync
echo.
echo 🔄 Running manual sync...
cd /d "d:\Sevastopol techs\e-ticket"
php artisan sync:background
pause
goto menu

:check_status
echo.
echo 📊 Detailed Status:
echo ==================
schtasks /query /tn "ETicketBackgroundSync" 2>nul
echo.
echo 🔄 Testing connection...
cd /d "d:\Sevastopol techs\e-ticket"
php artisan sync:background
pause
goto menu

:exit
echo.
echo 👋 Goodbye!
exit