<?php
// DevAnswers.net: PHP 8.1 fallback (prepare / bind_param / execute)
//   https://devanswers.net/php-mysqli-crud-prepared-statements/#prepare_bind_execute_fallback
//
// Use this pattern on PHP 8.1 (Ubuntu 22.04 default). For PHP 8.2+,
// see ../execute_query/create.php for the one-line shortcut.

require __DIR__ . '/../../connect.php';

$stmt = $mysqli->prepare(
    'INSERT INTO members (name, email, role, credits) VALUES (?, ?, ?, ?)'
);

$name    = 'Fiona Doyle';
$email   = 'fiona@devanswers.test';
$role    = 'editor';
$credits = 50.00;

// Type string 'sssd': string, string, string, double; one char per placeholder.
$stmt->bind_param('sssd', $name, $email, $role, $credits);
$stmt->execute();

echo 'Inserted id: ' . $stmt->insert_id . PHP_EOL;
