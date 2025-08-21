@echo off
echo Installing E-Ticket Sync as Windows Service...

sc create "ETicketSync" binPath= "cmd /c \"d:\Sevastopol techs\e-ticket\sync-service.bat\"" start= auto DisplayName= "E-Ticket Background Sync"
sc description "ETicketSync" "Automatically syncs E-Ticket data to remote server every minute"
sc start "ETicketSync"

echo Service installed and started!
echo You can manage it from Windows Services or use:
echo   sc stop ETicketSync    - to stop
echo   sc start ETicketSync   - to start
echo   sc delete ETicketSync  - to remove
pause