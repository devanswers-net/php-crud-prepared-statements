<?php
require __DIR__ . '/../../connect.php';

$sql    = 'SELECT id, name, email, role FROM members WHERE credits > ?';
$result = $mysqli->execute_query($sql, [10.00]);

foreach ($result as $row) {
    echo "{$row['id']} {$row['name']} <{$row['email']}> ({$row['role']})" . PHP_EOL;
}
