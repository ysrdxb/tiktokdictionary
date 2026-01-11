<?php
// Debug Toolkit Phase 2: URL & Connection Testing
error_reporting(E_ALL);
ini_set('display_errors', 1);

$manifestFile = __DIR__ . '/build/manifest.json';
$host = $_SERVER['HTTP_HOST'];
$uri = $_SERVER['REQUEST_URI'];
// attempt to detect base path
$scriptName = $_SERVER['SCRIPT_NAME']; // /tiktokdictionary/public/debug.php
$basePath = dirname(dirname($scriptName)); // /tiktokdictionary
if ($basePath === '/' || $basePath === '\\') $basePath = '';

echo "<style>body{font-family:sans-serif;max-width:800px;margin:20px auto} .ok{color:green} .fail{color:red} pre{background:#eee;padding:10px}</style>";
echo "<h1>🔍 Asset URL Tester</h1>";

if (!file_exists($manifestFile)) {
    die("<div class='fail'>Manifest missing!</div>");
}

$json = json_decode(file_get_contents($manifestFile), true);
$cssFile = $json['resources/css/app.css']['file'] ?? '';

if (!$cssFile) {
    die("<div class='fail'>CSS not in manifest</div>");
}

// Construct Candidates (Common Laravel deployments)
$candidates = [
    "Standard (Rewrite)" => "http://$host$basePath/build/$cssFile",
    "Direct (Public)"   => "http://$host$basePath/public/build/$cssFile",
    "Rel Root"          => "http://$host/build/$cssFile"
];

echo "<h3>Testing URLs for: $cssFile</h3>";

foreach ($candidates as $label => $url) {
    echo "<div><strong>$label:</strong> <a href='$url' target='_blank'>$url</a> ... ";
    
    // Simple HTTP Check
    $headers = @get_headers($url);
    if ($headers && strpos($headers[0], '200') !== false) {
        echo "<span class='ok'>✅ 200 OK (Use this!)</span>";
    } elseif ($headers) {
        echo "<span class='fail'>❌ " . $headers[0] . "</span>";
    } else {
        echo "<span class='fail'>❌ Connection Failed</span>";
    }
    echo "</div><hr>";
}

echo "<h3>Recommendation</h3>";
echo "<ul>";
echo "<li>If <strong>Direct (Public)</strong> works but Standard fails: Update your <code>.env</code> file with: <br><code>ASSET_URL=/tiktokdictionary/public</code></li>";
echo "<li>If <strong>Standard</strong> works: Clear your browser cache hard.</li>";
echo "</ul>";
