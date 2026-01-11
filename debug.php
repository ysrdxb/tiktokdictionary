<?php
// Debug Toolkit Phase 3: Root Structure Verification
error_reporting(E_ALL);
ini_set('display_errors', 1);

// New paths for Root Structure
$baseDir = __DIR__ . '/';
$manifestFile = $baseDir . 'build/manifest.json';
$hotFile = $baseDir . 'hot';
$viewDir = $baseDir . 'storage/framework/views/';

echo "<style>body{font-family:sans-serif;max-width:800px;margin:20px auto;color:#333} .ok{color:green} .fail{color:red} h1{border-bottom:1px solid #ddd} .box{background:#f9f9f9;padding:15px;margin:15px 0;border:1px solid #ddd}</style>";
echo "<h1>🚀 Root Structure Diagnostic</h1>";

// 1. HOT FILE
if (file_exists($hotFile)) {
    unlink($hotFile);
    echo "<div class='box fail'>⚠ Deleted residual 'hot' file.</div>";
} else {
    echo "<div class='box ok'>✓ No 'hot' file found.</div>";
}

// 2. MANIFEST
if (file_exists($manifestFile)) {
    echo "<div class='box ok'>✓ Manifest Found at: build/manifest.json</div>";
    $json = json_decode(file_get_contents($manifestFile), true);
    $css = $json['resources/css/app.css']['file'] ?? '';
    
    if ($css) {
        $realPath = $baseDir . 'build/' . $css;
        echo "<div>CSS Entry: $css</div>";
        if (file_exists($realPath)) {
             echo "<div class='ok'>✓ CSS File Exists on Disk</div>";
             
             // URL Check
             $host = $_SERVER['HTTP_HOST'];
             $uri = dirname($_SERVER['SCRIPT_NAME']);
             if ($uri === '/' || $uri === '\\') $uri = '';
             $url = "http://$host$uri/build/$css";
             
             echo "<div>Start Verification: <a href='$url' target='_blank'>$url</a></div>";
        } else {
             echo "<div class='fail'>❌ CSS File Missing on Disk: $realPath</div>";
        }
    }
} else {
    echo "<div class='box fail'>❌ Manifest NOT FOUND at: $manifestFile</div>";
}

// 3. Clear Views
$views = glob($viewDir . '*.php');
foreach ($views as $f) {
    if (is_file($f)) unlink($f);
}
echo "<div class='box ok'>✓ View Cache Cleared.</div>";

echo "<hr><a href='index.php'>Go to Homepage</a>";
