<?php
// DevAnswers.net: PHP 8.1 fallback SELECT (prepare + bind_param + get_result)
//   https://devanswers.net/php-mysqli-crud-prepared-statements/#prepare_bind_execute_fallback

require __DIR__ . '/../../connect.php';

$stmt = $mysqli->prepare(
    'SELECT id, name, email FROM members WHERE id < ?'
);

$max_id = 10;
$stmt->bind_param('i', $max_id);    // 'i' = integer
$stmt->execute();

$result = $stmt->get_result();      // get_result() requires the mysqlnd driver
foreach ($result as $row) {
    print_r($row);
}
