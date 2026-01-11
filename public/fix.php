<?php
// Emergency Fixer
// 1. Clears Cache
// 2. Removes 'hot' file (fixes local network error)
// 3. Clears Views (fixes path errors)

$baseDir = __DIR__ . '/../';
$cacheDir = $baseDir . 'bootstrap/cache/';
$viewDir = $baseDir . 'storage/framework/views/';
$hotFile = __DIR__ . '/hot';

echo "<h1>TikTokDictionary Fixer</h1>";

// 1. Delete HOT file
if (file_exists($hotFile)) {
    if (unlink($hotFile)) {
        echo "<p style='color:green'>✓ Deleted 'hot' file (Fixed Local Network Error)</p>";
    } else {
        echo "<p style='color:red'>✗ Failed to delete 'hot' file. Please delete it manually via FTP.</p>";
    }
} else {
    echo "<p style='color:blue'>✓ No 'hot' file found (Good)</p>";
}

// 2. Clear Views
$params = glob($viewDir . '*.php');
foreach ($params as $file) {
    if (is_file($file)) {
        unlink($file);
    }
}
echo "<p style='color:green'>✓ Blade Views Cleared (Fixed Asset Paths)</p>";

// 3. Clear Bootstrap Cache
$files = ['config.php', 'routes-v7.php', 'services.php', 'packages.php'];
foreach ($files as $file) {
    $path = $cacheDir . $file;
    if (file_exists($path)) {
        unlink($path);
        echo "✓ Deleted cache: $file<br>";
    }
}

echo "<hr>";
echo "<h3><a href='/tiktokdictionary/'>Click here to Open Site</a></h3>";
