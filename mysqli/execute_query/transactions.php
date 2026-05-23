<?php
// DevAnswers.net: atomic admin handoff via mysqli transactions
//   https://devanswers.net/php-mysqli-crud-prepared-statements/#transactions

require __DIR__ . '/../../connect.php';

$mysqli->begin_transaction();
try {
    // Promote Declan Walsh (id 2) to admin.
    $mysqli->execute_query(
        'UPDATE members SET role = ? WHERE id = ?',
        ['admin', 2]
    );
    // Demote the previous admin (Maeve Gallagher, id 1) to editor.
    $mysqli->execute_query(
        'UPDATE members SET role = ? WHERE id = ?',
        ['editor', 1]
    );
    $mysqli->commit();
    echo 'DevAnswers admin handoff complete.' . PHP_EOL;
} catch (mysqli_sql_exception $e) {
    $mysqli->rollback();
    throw $e;
}
