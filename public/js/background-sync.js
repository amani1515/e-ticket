// Background sync every 60 seconds
(function() {
    let syncInterval;
    
    function backgroundSync() {
        fetch('/admin/sync/now', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.synced > 0) {
                console.log('Background sync:', data.message);
            }
        })
        .catch(error => {
            console.log('Background sync error:', error.message);
        });
    }
    
    // Start background sync every 60 seconds
    function startBackgroundSync() {
        if (syncInterval) clearInterval(syncInterval);
        syncInterval = setInterval(backgroundSync, 60000);
        console.log('Background sync started (every 60 seconds)');
    }
    
    // Auto-start when page loads
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', startBackgroundSync);
    } else {
        startBackgroundSync();
    }
    
    // Expose global control
    window.ETicketSync = {
        start: startBackgroundSync,
        stop: function() {
            if (syncInterval) {
                clearInterval(syncInterval);
                syncInterval = null;
                console.log('Background sync stopped');
            }
        },
        syncNow: backgroundSync
    };
})();