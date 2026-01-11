<?php
// Debug Toolkit Phase 5: Laravel Boot & Route Check
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<style>body{font-family:sans-serif;max-width:900px;margin:20px auto} .box{padding:15px;margin:10px 0;border:1px solid #ccc;background:#f9f9f9} .ok{color:green} .fail{color:red}</style>";
echo "<h1>🚀 Root Structure & Route Diagnostic</h1>";

$baseDir = __DIR__;

// 1. FILE CHECK
echo "<h3>1. File Structure</h3>";
$files = [
    'vendor/autoload.php',
    'bootstrap/app.php',
    '.env',
    'build/manifest.json'
];
foreach($files as $f) {
    if(file_exists($baseDir . '/' . $f)) {
        echo "<div class='ok'>✓ Found: $f</div>";
    } else {
        echo "<div class='fail'>❌ MISSING: $f</div>";
    }
}

// 2. BOOT LARAVEL
echo "<h3>2. Booting Laravel...</h3>";
try {
    require $baseDir . '/vendor/autoload.php';
    $app = require_once $baseDir . '/bootstrap/app.php';
    
    // Register the Public Path fix manually here to test
    $app->usePublicPath($baseDir);
    
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    
    // Create Request
    $request = Illuminate\Http\Request::capture();
    
    echo "<div class='box'>";
    echo "<strong>URI:</strong> " . $request->getRequestUri() . "<br>";
    echo "<strong>Path Info:</strong> " . $request->getPathInfo() . "<br>";
    echo "<strong>Base URL:</strong> " . $request->getBaseUrl() . "<br>";
    echo "<strong>Method:</strong> " . $request->getMethod() . "<br>";
    echo "<strong>Detected Public Path:</strong> " . public_path() . "<br>";
    echo "</div>";
    
    // Check Manifest Path via Laravel
    $manifestPath = public_path('build/manifest.json');
    echo "<div>Laravel looking for manifest at: $manifestPath</div>";
    if (file_exists($manifestPath)) {
        echo "<div class='ok'>✓ Laravel finds manifest!</div>";
    } else {
        echo "<div class='fail'>❌ Laravel CANNOT find manifest. (Public Path mismatch?)</div>";
    }

} catch (Throwable $e) {
    echo "<div class='fail box'>❌ <strong>CRITICAL BOOT ERROR:</strong><br>" . $e->getMessage() . "<br><pre>" . $e->getTraceAsString() . "</pre></div>";
}

echo "<hr><a href='index.php'>Go to Homepage</a>";
