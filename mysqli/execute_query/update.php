<?php
require __DIR__ . '/../../connect.php';

// Compare-and-set: only promote if member is still 'user'. Concurrent-safe.
$sql = 'UPDATE members SET role = ? WHERE id = ? AND role = ?';
$ok  = $mysqli->execute_query($sql, ['editor', 1, 'user']);

if ($ok) {
    echo 'Rows updated: ' . $mysqli->affected_rows . PHP_EOL;
}
