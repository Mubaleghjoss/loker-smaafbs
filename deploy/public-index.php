<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$appRoot = realpath(__DIR__ . '/../../../laravel-lokersmaafbs');

if ($appRoot === false) {
    http_response_code(503);
    echo 'Laravel root not found.';
    exit;
}

if (file_exists($maintenance = $appRoot . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $appRoot . '/vendor/autoload.php';

(require_once $appRoot . '/bootstrap/app.php')
    ->handleRequest(Request::capture());
