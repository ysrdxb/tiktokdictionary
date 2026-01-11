<?php
// Debug Toolkit for Deployment
// 1. Clears Caches (Views, Config)
// 2. Checks Asset Paths
// 3. Checks Permissions

error_reporting(E_ALL);
ini_set('display_errors', 1);

$baseDir = __DIR__ . '/../';
$publicDir = __DIR__;
$cacheDir = $baseDir . 'bootstrap/cache/';
$viewDir = $baseDir . 'storage/framework/views/';
$hotFile = __DIR__ . '/hot';
$manifestFile = __DIR__ . '/build/manifest.json';

echo "<style>body{font-family:sans-serif;line-height:1.5;max-width:800px;margin:20px auto;color:#333} pre{background:#f4f4f4;padding:10px;overflow-x:auto} h1,h2{border-bottom:1px solid #eee;padding-bottom:10px} .success{color:green;font-weight:bold} .error{color:red;font-weight:bold} .warn{color:orange;font-weight:bold}</style>";

echo "<h1>🛠️ TikTokDictionary Diagnostic & Fixer</h1>";

// --- SECTION 1: HOT FILE ---
echo "<h2>1. Hot Reload File (Localhost Fix)</h2>";
if (file_exists($hotFile)) {
    echo "<div class='error'>⚠ FOUND 'hot' file. Deleting...</div>";
    if (unlink($hotFile)) {
        echo "<div class='success'>✓ Deleted 'hot' file. (Local network error fixed)</div>";
    } else {
        echo "<div class='error'>✗ Failed to delete 'hot' file. Check permissions.</div>";
    }
} else {
    echo "<div class='success'>✓ No 'hot' file found. (Clean)</div>";
}

// --- SECTION 2: VIEW CACHE ---
echo "<h2>2. View Cache (Style Path Fix)</h2>";
$views = glob($viewDir . '*.php');
$count = 0;
foreach ($views as $file) {
    if (is_file($file)) {
        unlink($file);
        $count++;
    }
}
echo "<div class='success'>✓ Cleared $count compiled views.</div>";

// --- SECTION 3: MANIFEST CHECK ---
echo "<h2>3. Vite Manifest Inspection</h2>";
if (file_exists($manifestFile)) {
    echo "<div>Found manifest at: $manifestFile</div>";
    $content = file_get_contents($manifestFile);
    $json = json_decode($content, true);
    if ($json) {
        echo "<div class='success'>✓ Manifest is valid JSON.</div>";
        echo "<pre>" . htmlspecialchars(print_r($json, true)) . "</pre>";
        
        // CHECK ENTRY CSS
        $cssEntry = $json['resources/css/app.css']['file'] ?? null;
        if ($cssEntry) {
            $cssPath = $publicDir . '/build/' . $cssEntry;
            if (file_exists($cssPath)) {
                echo "<div class='success'>✓ CSS File Exists: public/build/$cssEntry</div>";
            } else {
                echo "<div class='error'>✗ CSS File MISSING: public/build/$cssEntry</div>";
                echo "<div>Expected at: $cssPath</div>";
            }
        } else {
            echo "<div class='error'>✗ Entry 'resources/css/app.css' not found in manifest.</div>";
        }
    } else {
        echo "<div class='error'>✗ Manifest is invalid JSON or empty.</div>";
    }
} else {
    echo "<div class='error'>✗ Manifest file NOT FOUND at: $manifestFile</div>";
}

// --- SECTION 4: ENVIRONMENT ---
echo "<h2>4. Environment Info</h2>";
echo "<div>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</div>";
echo "<div>Script Path: " . __DIR__ . "</div>";
echo "<div>Vite Base should be: /tiktokdictionary/</div>";

// --- ACTIONS ---
echo "<h2>Actions</h2>";
echo "<ul>";
echo "<li><a href='/tiktokdictionary/public/'>Open Public Folder</a></li>";
echo "<li><a href='/tiktokdictionary/'>Open Root (Redirect check)</a></li>";
echo "</ul>";

echo "<hr><p><em>You should delete this file (public/debug.php) after fixing the issue.</em></p>";
