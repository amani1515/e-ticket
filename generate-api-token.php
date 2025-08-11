<?php

// Generate a secure API token for sync operations
$token = 'SYNC_' . bin2hex(random_bytes(32));

echo "Generated API Token:\n";
echo "====================\n";
echo $token . "\n\n";

echo "Add this to your .env files:\n";
echo "SYNC_API_TOKEN=" . $token . "\n\n";

echo "Local Server (.env):\n";
echo "SYNC_REMOTE_URL=https://eticket.capitalltechs.com\n";
echo "SYNC_API_TOKEN=" . $token . "\n\n";

echo "Remote Server (.env):\n";
echo "SYNC_API_TOKEN=" . $token . "\n";
?>