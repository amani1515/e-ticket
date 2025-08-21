# E-Ticket Background Sync Setup

## Automatic Background Sync Options

### Option 1: Windows Task Scheduler (Recommended)
Run as Administrator:
```
setup-task-scheduler.bat
```
This creates a Windows task that runs every minute automatically.

### Option 2: Windows Service
Run as Administrator:
```
install-sync-service.bat
```
This installs a Windows service for background sync.

### Option 3: Manual Background Process
```
sync-service.bat
```
Runs in a command window (must stay open).

### Option 4: Web-based Auto Sync
The system now automatically syncs every 60 seconds when users are active on the website.

## Manual Commands

- `php artisan sync:data` - Manual sync
- `php artisan sync:background` - Single background sync
- `php artisan sync:data --continuous` - Continuous sync

## Monitoring

- Check logs: `storage/logs/laravel.log`
- Admin sync page: `/admin/sync`
- Browser console shows background sync activity

## Status

✅ Background sync runs every 60 seconds
✅ No data loss - items retry until successful  
✅ Works without opening sync page
✅ Multiple sync methods available