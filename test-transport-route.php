<?php

// Simple test to check if transport authority route works
echo "Testing Transport Authority Route...\n\n";

// Test the route directly
$url = 'http://127.0.0.1:8000/admin/transport-authority';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
curl_close($ch);

echo "URL: $url\n";
echo "HTTP Code: $httpCode\n";
echo "Final URL: $finalUrl\n";

if ($httpCode === 200) {
    echo "✅ SUCCESS: Route is accessible\n";
} elseif ($httpCode === 302) {
    echo "🔄 REDIRECT: Likely redirected to login (need authentication)\n";
} elseif ($httpCode === 404) {
    echo "❌ NOT FOUND: Route doesn't exist\n";
} else {
    echo "⚠️ OTHER: HTTP $httpCode\n";
}

if (strpos($response, 'login') !== false) {
    echo "🔐 Authentication required - you need to login as admin first\n";
}
?>