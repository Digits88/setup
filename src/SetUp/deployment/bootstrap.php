<?php

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';
Dotenv::load(__DIR__ . '/../');
$app = require_once __DIR__.'/../bootstrap/app.php';

return $app;