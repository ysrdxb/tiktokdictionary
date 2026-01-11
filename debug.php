<?php
// Debug Toolkit Phase 4: Flat Structure + URL Check
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Directory is now root
$baseDir = __DIR__ . '/';
$manifestFile = $baseDir . 'build/manifest.json';
// URL Base
$uri = $_SERVER['REQUEST_URI'];
// /tiktokdictionary/debug.php -> base is /tiktokdictionary
$scriptName = $_SERVER['SCRIPT_NAME'];
$urlBase = dirname($scriptName); 
if ($urlBase === '/' || $urlBase === '\\') $urlBase = '';

echo "<style>body{font-family:sans-serif;max-width:800px;margin:20px auto} .ok{color:green} .fail{color:red} .box{background:#f9f9f9;padding:15px;margin:15px 0;border-left:5px solid #333}</style>";
echo "<h1>🚀 Root Structure Diagnostic</h1>";

// 1. MANIFEST
if (file_exists($manifestFile)) {
    echo "<div class='box ok'>✓ Manifest Found at: build/manifest.json</div>";
    $json = json_decode(file_get_contents($manifestFile), true);
    $css = $json['resources/css/app.css']['file'] ?? '';
    
    if ($css) {
        $realPath = $baseDir . 'build/' . $css;
        // The URL should be base/build/assets/file.css
        $assetUrl = "http://" . $_SERVER['HTTP_HOST'] . $urlBase . "/build/" . $css;
        
        echo "<div><strong>CSS Asset:</strong> $css</div>";
        echo "<div><strong>Checking URL:</strong> <a href='$assetUrl' target='_blank'>$assetUrl</a></div>";
        
        $headers = @get_headers($assetUrl);
        if ($headers && strpos($headers[0], '200') !== false) {
             echo "<div class='ok'>✅ 200 OK - Asset should load!</div>";
        } elseif ($headers) {
             echo "<div class='fail'>❌ " . $headers[0] . " - Still Redirecting or missing?</div>";
        } else {
             echo "<div class='fail'>❌ Connection Failed</div>";
        }
        
    }
} else {
    echo "<div class='box fail'>❌ Manifest NOT FOUND at: $manifestFile</div>";
}

echo "<hr><a href='index.php'>Go to Homepage</a>";
