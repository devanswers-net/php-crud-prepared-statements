<?php
// DevAnswers.net: end-to-end CLI walkthrough
//   https://devanswers.net/php-mysqli-crud-prepared-statements/
//
// Runs the article's INSERT, SELECT, UPDATE, DELETE, TRANSACTIONS flow
// in one go and prints expected output. Assumes you ran schema.sql and that
// the members table is empty. To run:
//   php mysqli/cli_demo.php

require __DIR__ . '/../connect.php';

echo '== DevAnswers MySQLi CRUD demo ==' . PHP_EOL;
echo 'Connected to MySQL ' . $mysqli->server_info . PHP_EOL;
echo PHP_EOL;

// 1. CREATE. Insert Maeve Gallagher as a 'user'.
echo '-- INSERT --' . PHP_EOL;
$mysqli->execute_query(
    'INSERT INTO members (name, email, role, credits) VALUES (?, ?, ?, ?)',
    ['Maeve Gallagher', 'maeve@devanswers.test', 'user', 25.00]
);
$maeve_id = $mysqli->insert_id;
echo "Inserted id: {$maeve_id}" . PHP_EOL . PHP_EOL;

// Also insert Declan so the transactions step has someone to promote.
$mysqli->execute_query(
    'INSERT INTO members (name, email, role, credits) VALUES (?, ?, ?, ?)',
    ['Declan Walsh', 'declan@devanswers.test', 'editor', 50.00]
);
$declan_id = $mysqli->insert_id;

// 2. READ. Select members with positive credit balance.
echo '-- SELECT WHERE credits > 10.00 --' . PHP_EOL;
$result = $mysqli->execute_query(
    'SELECT id, name, email, role FROM members WHERE credits > ?',
    [10.00]
);
foreach ($result as $row) {
    echo "{$row['id']} {$row['name']} <{$row['email']}> ({$row['role']})" . PHP_EOL;
}
echo PHP_EOL;

// 3. UPDATE. Promote Maeve from 'user' to 'editor' (compare-and-set guard).
echo '-- UPDATE: promote Maeve from user to editor --' . PHP_EOL;
$mysqli->execute_query(
    'UPDATE members SET role = ? WHERE id = ? AND role = ?',
    ['editor', $maeve_id, 'user']
);
echo 'Rows updated: ' . $mysqli->affected_rows . PHP_EOL . PHP_EOL;

// 4. DELETE. id=42 does not exist; affected_rows returns 0.
echo '-- DELETE id=42 (not present) --' . PHP_EOL;
$mysqli->execute_query('DELETE FROM members WHERE id = ?', [42]);
echo 'Rows deleted: ' . $mysqli->affected_rows . PHP_EOL . PHP_EOL;

// 5. TRANSACTIONS. Atomic admin handoff: promote Declan, demote Maeve.
echo '-- TRANSACTION: atomic admin handoff --' . PHP_EOL;
$mysqli->begin_transaction();
try {
    $mysqli->execute_query(
        'UPDATE members SET role = ? WHERE id = ?',
        ['admin', $declan_id]
    );
    $mysqli->execute_query(
        'UPDATE members SET role = ? WHERE id = ?',
        ['user', $maeve_id]
    );
    $mysqli->commit();
    echo 'DevAnswers admin handoff complete.' . PHP_EOL;
} catch (mysqli_sql_exception $e) {
    $mysqli->rollback();
    throw $e;
}

echo PHP_EOL . '== Demo finished ==' . PHP_EOL;
echo 'Tip: open mysqli/index.php in a browser to see the same data via the HTML UI.' . PHP_EOL;
