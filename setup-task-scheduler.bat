@echo off
echo Setting up Windows Task Scheduler for E-Ticket Background Sync...

schtasks /create /tn "ETicketBackgroundSync" /tr "php \"d:\Sevastopol techs\e-ticket\artisan\" sync:background" /sc minute /mo 1 /st 00:00 /sd %date% /ru SYSTEM /f

if %errorlevel% == 0 (
    echo ✅ Task scheduled successfully!
    echo Background sync will run every minute automatically.
    echo.
    echo To manage the task:
    echo   schtasks /run /tn "ETicketBackgroundSync"     - Run now
    echo   schtasks /end /tn "ETicketBackgroundSync"     - Stop
    echo   schtasks /delete /tn "ETicketBackgroundSync"  - Remove
) else (
    echo ❌ Failed to create scheduled task. Run as Administrator.
)

pause