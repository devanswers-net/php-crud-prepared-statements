<?php
require __DIR__ . '/../../connect.php';

// Always include a WHERE clause; DELETE FROM members; would empty the table.
$sql = 'DELETE FROM members WHERE id = ?';
$ok  = $mysqli->execute_query($sql, [42]);

echo 'Rows deleted: ' . $mysqli->affected_rows . PHP_EOL;
