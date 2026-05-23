<?php
// DevAnswers.net: shared mysqli connection bootstrap
//   https://devanswers.net/php-mysqli-crud-prepared-statements/
//
// Loaded by every CRUD example via require __DIR__ . '/connect.php'.
// Reads credentials from config.php (gitignored).

declare(strict_types=1);

// Throw mysqli_sql_exception on any error, including connection failures.
// Recommended for all PHP 8.x production code; replaces the old "check return
// value, then call $mysqli->error" pattern.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$config_path = __DIR__ . '/config.php';
if (! file_exists($config_path)) {
    fwrite(STDERR, "config.php not found. Copy config.sample.php to config.php and edit." . PHP_EOL);
    exit(1);
}
$config = require $config_path;

$mysqli = new mysqli(
    $config['db_host'],
    $config['db_user'],
    $config['db_pass'],
    $config['db_name']
);
$mysqli->set_charset('utf8mb4');

// $mysqli is now available to whatever script required this file.
