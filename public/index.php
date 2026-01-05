<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Check for maintenance mode
if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Autoload Composer dependencies
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap the application
/** @var Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Handle the request
$app->handleRequest(Request::capture());