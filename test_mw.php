<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckMaintenanceMode;

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

echo "Testing Maintenance Middleware...\n";

// 1. Check Setting Value directly
$val = \App\Models\Setting::get('maintenance_mode');
echo "Current Setting Value: " . var_export($val, true) . "\n";
echo "Trimmed Value: " . var_export(trim($val), true) . "\n";
echo "Bool Filter: " . (filter_var(trim($val), FILTER_VALIDATE_BOOLEAN) ? 'TRUE' : 'FALSE') . "\n\n";

// 2. Mock Request (Guest)
$request = Request::create('/', 'GET');
$middleware = new CheckMaintenanceMode();

$response = $middleware->handle($request, function ($req) {
    return "PASSED_THROUGH";
});

if ($response instanceof \Symfony\Component\HttpFoundation\Response) {
    echo "Result: RESPONSE OBJECT (" . $response->getStatusCode() . ")\n";
} else {
    echo "Result: " . $response . "\n";
}
