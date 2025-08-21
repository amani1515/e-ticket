# E-Ticket Background Sync Control

## 🎛️ Easy ON/OFF Control

### Quick Start (Recommended)
**Use the Control Panel for everything:**
```
Double-click: sync-control-panel.bat
```
- Shows current sync status (ON/OFF)
- Easy menu to start/stop sync
- All-in-one solution

### Manual ON/OFF Control

#### 🚀 Turn ON Background Sync
```
Right-click → Run as Administrator:
setup-task-scheduler.bat
```
**What happens:**
- Creates Windows Task Scheduler
- Syncs every 1 minute automatically
- Runs forever in background
- No windows need to stay open

#### 🛑 Turn OFF Background Sync  
```
Double-click:
stop-background-sync.bat
```
**What happens:**
- Deletes Windows Task Scheduler
- Stops all sync processes
- Completely disables background sync
- System works normally, just no auto-sync

## 📋 How It Works

### When Sync is ON:
- ✅ Data syncs every minute automatically
- ✅ Works in background (invisible)
- ✅ No manual work needed
- ✅ Use your system normally

### When Sync is OFF:
- ❌ No automatic syncing
- ❌ Data stays local only
- ✅ System works normally
- ✅ Can still sync manually

## 🔧 Available Files

| File | Purpose | When to Use |
|------|---------|-------------|
| `sync-control-panel.bat` | **Main Control** | **Use this for everything** |
| `setup-task-scheduler.bat` | Turn ON sync | Start background sync |
| `stop-background-sync.bat` | Turn OFF sync | Stop background sync |
| `check-sync-status.bat` | Check status | View current status |

## 🖥️ New PC Installation

1. **Install e-ticket system normally**
2. **Run ONCE as Administrator:** `setup-task-scheduler.bat`
3. **Done!** Sync works automatically

## 💡 Usage Examples

### Scenario 1: Normal Operation
- Run `setup-task-scheduler.bat` once
- Use your system normally
- Data syncs automatically every minute

### Scenario 2: Temporary Disable
- Run `stop-background-sync.bat`
- Work offline (no sync)
- Run `setup-task-scheduler.bat` to re-enable

### Scenario 3: Troubleshooting
- Use `sync-control-panel.bat`
- Check status and test manually
- Start/stop as needed

## 🔍 Monitoring & Status

- **Admin Panel:** `/admin/sync` - View sync activity
- **Logs:** `storage/logs/laravel.log` - Detailed sync logs
- **Task Manager:** Check "ETicketBackgroundSync" task
- **Control Panel:** `sync-control-panel.bat` - Quick status

## ✅ Current Features

✅ **Easy ON/OFF control** - Simple batch files
✅ **No data loss** - Items retry until successful  
✅ **Background operation** - No windows need to stay open
✅ **Multiple control methods** - Control panel + individual files
✅ **Status monitoring** - Check if sync is running
✅ **New PC ready** - Easy installation on new computers

## 🚨 Important Notes

- **Always run `setup-task-scheduler.bat` as Administrator**
- **Sync works completely in background** - no visible windows
- **You can turn ON/OFF anytime** without affecting your system
- **Data is safe** - failed items keep retrying until successful
- **System works normally** whether sync is ON or OFF