<?php
// DevAnswers.net: shared PDO connection bootstrap
//   https://devanswers.net/php-pdo-crud-prepared-statements/
//
// Loaded by every CRUD example via require __DIR__ . '/connect.php'.
// Reads credentials from ../config.php (gitignored, copied from
// ../config.sample.php at setup).

declare(strict_types=1);

$config = require __DIR__ . '/../config.php';

$dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4";

// PDO::ERRMODE_EXCEPTION is the default since PHP 8.0; setting it explicitly
// keeps the intent visible to readers of this file. The other two attributes
// (default fetch mode + native prepares) are the recommended modern defaults.
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], $options);
