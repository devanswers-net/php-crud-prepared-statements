<?php
// DevAnswers.net: end-to-end CLI walkthrough (PDO version)
//   https://devanswers.net/php-pdo-crud-prepared-statements/
//
// Runs the article's INSERT, SELECT, UPDATE, DELETE, TRANSACTIONS flow
// in one go and prints expected output. Assumes you ran schema.sql and that
// the members table is empty. To run:
//   php pdo/cli_demo.php

require __DIR__ . '/connect.php';

echo '== DevAnswers PDO CRUD demo ==' . PHP_EOL;
echo 'Connected to MySQL ' . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . PHP_EOL;
echo PHP_EOL;

// 1. CREATE. Insert Maeve Gallagher as a 'user'.
echo '-- INSERT --' . PHP_EOL;
$stmt = $pdo->prepare(
    'INSERT INTO members (name, email, role, credits) VALUES (:name, :email, :role, :credits)'
);
$stmt->execute([
    ':name'    => 'Maeve Gallagher',
    ':email'   => 'maeve@devanswers.test',
    ':role'    => 'user',
    ':credits' => 25.00,
]);
$maeve_id = (int) $pdo->lastInsertId();
echo "Inserted id: {$maeve_id}" . PHP_EOL . PHP_EOL;

// Also insert Declan so the transactions step has someone to promote.
$stmt = $pdo->prepare(
    'INSERT INTO members (name, email, role, credits) VALUES (:name, :email, :role, :credits)'
);
$stmt->execute([
    ':name'    => 'Declan Walsh',
    ':email'   => 'declan@devanswers.test',
    ':role'    => 'editor',
    ':credits' => 50.00,
]);
$declan_id = (int) $pdo->lastInsertId();

// 2. READ. Select members with positive credit balance.
echo '-- SELECT WHERE credits > 10.00 --' . PHP_EOL;
$stmt = $pdo->prepare(
    'SELECT id, name, email, role FROM members WHERE credits > :min'
);
$stmt->execute([':min' => 10.00]);
foreach ($stmt as $row) {
    echo "{$row['id']} {$row['name']} <{$row['email']}> ({$row['role']})" . PHP_EOL;
}
echo PHP_EOL;

// 3. UPDATE. Promote Maeve from 'user' to 'editor' (compare-and-set guard).
echo '-- UPDATE: promote Maeve from user to editor --' . PHP_EOL;
$stmt = $pdo->prepare(
    'UPDATE members SET role = :new WHERE id = :id AND role = :old'
);
$stmt->execute([':new' => 'editor', ':id' => $maeve_id, ':old' => 'user']);
echo 'Rows updated: ' . $stmt->rowCount() . PHP_EOL . PHP_EOL;

// 4. DELETE. id=42 does not exist; rowCount returns 0.
echo '-- DELETE id=42 (not present) --' . PHP_EOL;
$stmt = $pdo->prepare('DELETE FROM members WHERE id = :id');
$stmt->execute([':id' => 42]);
echo 'Rows deleted: ' . $stmt->rowCount() . PHP_EOL . PHP_EOL;

// 5. TRANSACTIONS. Atomic admin handoff: promote Declan, demote Maeve.
echo '-- TRANSACTION: atomic admin handoff --' . PHP_EOL;
$pdo->beginTransaction();
try {
    $stmt = $pdo->prepare('UPDATE members SET role = :role WHERE id = :id');
    $stmt->execute([':role' => 'admin', ':id' => $declan_id]);
    if ($stmt->rowCount() !== 1) {
        throw new RuntimeException('Promotion row not found.');
    }
    $stmt->execute([':role' => 'user', ':id' => $maeve_id]);
    if ($stmt->rowCount() !== 1) {
        throw new RuntimeException('Demotion row not found.');
    }
    $pdo->commit();
    echo 'DevAnswers admin handoff complete.' . PHP_EOL;
} catch (PDOException | RuntimeException $e) {
    $pdo->rollBack();
    throw $e;
}

echo PHP_EOL . '== Demo finished ==' . PHP_EOL;
echo 'Tip: open pdo/index.php in a browser to see the same data via the HTML UI.' . PHP_EOL;
