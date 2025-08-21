@echo off
title Stop E-Ticket Background Sync
echo Stopping E-Ticket Background Sync...
echo.

echo 🛑 Deleting Windows Task Scheduler...
schtasks /delete /tn "ETicketBackgroundSync" /f >nul 2>&1
if %errorlevel% == 0 (
    echo ✅ Task Scheduler stopped successfully
) else (
    echo ⚠️  Task Scheduler not found or already stopped
)

echo.
echo 🛑 Stopping any running sync processes...
taskkill /f /im php.exe /fi "WINDOWTITLE eq *sync*" >nul 2>&1
taskkill /f /im cmd.exe /fi "WINDOWTITLE eq *Sync*" >nul 2>&1

echo.
echo 🛑 Stopping Windows Service (if exists)...
sc stop "ETicketSync" >nul 2>&1
sc delete "ETicketSync" >nul 2>&1

echo.
echo ✅ Background sync has been STOPPED completely!
echo.
echo To start background sync again:
echo   👉 Run "setup-task-scheduler.bat" as Administrator
echo.
pause