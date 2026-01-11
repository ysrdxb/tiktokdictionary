<?php
// Emergency cache clearer - delete this file after use!

$cacheDir = __DIR__ . '/../bootstrap/cache/';

$files = [
    'config.php',
    'routes-v7.php',
    'services.php',
    'packages.php',
    'events.php',
];

echo "<h2>Clearing Laravel Cache Files</h2>";

foreach ($files as $file) {
    $path = $cacheDir . $file;
    if (file_exists($path)) {
        if (unlink($path)) {
            echo "✓ Deleted: $file<br>";
        } else {
            echo "✗ Failed to delete: $file<br>";
        }
    } else {
        echo "- Not found: $file<br>";
    }
}

// Also clear any opcache
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "<br>✓ OPcache cleared<br>";
}

echo "<br><strong>Done!</strong><br><br>";
echo "<a href='/tiktokdictionary/'>Go to Homepage</a><br>";
echo "<a href='/tiktokdictionary/test123'>Test Route</a><br>";
echo "<br><em>Delete this fix.php file after use!</em>";
