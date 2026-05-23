<?php
require __DIR__ . '/../../connect.php';

$sql = 'INSERT INTO members (name, email, role, credits) VALUES (?, ?, ?, ?)';
$ok  = $mysqli->execute_query(
    $sql,
    ['Maeve Gallagher', 'maeve@devanswers.test', 'user', 25.00]
);

if ($ok) {
    echo 'Inserted id: ' . $mysqli->insert_id . PHP_EOL;
}
