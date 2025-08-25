@echo off
title Stop E-Ticket Background Sync
echo Stopping E-Ticket Background Sync...
echo.

echo [1/4] Deleting Windows Task Scheduler...
schtasks /delete /tn "ETicketBackgroundSync" /f >nul 2>&1
if %errorlevel% == 0 (
    echo SUCCESS: Task Scheduler stopped
) else (
    echo INFO: Task Scheduler not found or already stopped
)

echo.
echo [2/4] Stopping sync artisan commands...
set sync_killed=0
for /f "tokens=2" %%i in ('wmic process where "name='php.exe' and commandline like '%%sync:background%%'" get processid /format:csv 2^>nul ^| findstr /r "[0-9]"') do (
    taskkill /f /pid %%i >nul 2>&1
    set sync_killed=1
)
for /f "tokens=2" %%i in ('wmic process where "name='php.exe' and commandline like '%%sync:data%%'" get processid /format:csv 2^>nul ^| findstr /r "[0-9]"') do (
    taskkill /f /pid %%i >nul 2>&1
    set sync_killed=1
)
for /f "tokens=2" %%i in ('wmic process where "name='php.exe' and commandline like '%%sync:auto%%'" get processid /format:csv 2^>nul ^| findstr /r "[0-9]"') do (
    taskkill /f /pid %%i >nul 2>&1
    set sync_killed=1
)
if %sync_killed%==1 (
    echo SUCCESS: Sync processes stopped
) else (
    echo INFO: No sync processes found
)

echo.
echo [3/4] Stopping sync batch files...
for /f "tokens=2" %%i in ('wmic process where "name='cmd.exe' and (commandline like '%%sync-service.bat%%' or commandline like '%%start-sync.bat%%')" get processid /format:csv 2^>nul ^| findstr /r "[0-9]"') do (
    taskkill /f /pid %%i >nul 2>&1
)
echo INFO: Sync batch processes checked

echo.
echo [4/4] Stopping Windows Service...
sc stop "ETicketSync" >nul 2>&1
sc delete "ETicketSync" >nul 2>&1
echo INFO: Windows service checked

echo.
echo ===== SUMMARY =====
echo Background sync processes have been stopped!
echo Web server and other PHP processes remain running.
echo.
echo To restart sync:
echo   Run "setup-task-scheduler.bat" as Administrator
echo.
pause