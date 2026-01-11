<?php
// Debug script to check what's happening

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Boot the application
$app->boot();

echo "<h2>Route Debug</h2>";

// Get all registered routes
$routes = $app->make('router')->getRoutes();

echo "<h3>Registered Routes:</h3>";
echo "<pre>";
foreach ($routes as $route) {
    echo $route->methods()[0] . " " . $route->uri() . "\n";
}
echo "</pre>";

echo "<h3>Total routes: " . count($routes) . "</h3>";
