<?php
// DevAnswers.net: minimal HTML UI for the members table (PDO CRUD)
//   https://devanswers.net/php-pdo-crud-prepared-statements/
//
// Vanilla HTML + PHP, no framework, no JS. Open in a browser (e.g. via
// `php -S localhost:8000` from the repo root, then visit
// http://localhost:8000/pdo/index.php).

require __DIR__ . '/connect.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'create') {
        $name    = trim($_POST['name'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $role    = $_POST['role'] ?? 'user';
        $credits = (float) ($_POST['credits'] ?? 0);

        if ($name === '' || $email === '') {
            $message = 'Name and email are required.';
        } elseif (! in_array($role, ['user', 'editor', 'admin'], true)) {
            $message = 'Role must be user, editor, or admin.';
        } else {
            try {
                $stmt = $pdo->prepare(
                    'INSERT INTO members (name, email, role, credits) VALUES (:name, :email, :role, :credits)'
                );
                $stmt->execute([
                    ':name'    => $name,
                    ':email'   => $email,
                    ':role'    => $role,
                    ':credits' => $credits,
                ]);
                $message = "Added {$name} (id {$pdo->lastInsertId()}).";
            } catch (PDOException $e) {
                // 23000 = integrity constraint violation; email is UNIQUE in the schema.
                $message = $e->getCode() === '23000'
                    ? "A member with email {$email} already exists."
                    : 'Insert failed: ' . $e->getMessage();
            }
        }
    } elseif ($action === 'delete') {
        $id = (int) ($_POST['id'] ?? 0);
        $stmt = $pdo->prepare('DELETE FROM members WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $message = "Deleted id {$id} ({$stmt->rowCount()} row removed).";
    }
}

$members = $pdo->query(
    'SELECT id, name, email, role, credits, joined FROM members ORDER BY id'
);

function h(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>DevAnswers Members Admin (PDO CRUD demo)</title>
<style>
    body  { font-family: system-ui, sans-serif; max-width: 800px; margin: 2rem auto; padding: 0 1rem; }
    h1    { border-bottom: 1px solid #ccc; padding-bottom: 0.3rem; }
    h2    { margin-top: 2rem; }
    table { border-collapse: collapse; width: 100%; margin: 1rem 0; }
    th, td { padding: 0.4rem 0.7rem; text-align: left; border-bottom: 1px solid #eee; }
    th    { background: #f5f5f5; }
    form.inline { display: inline; }
    .msg   { padding: 0.6rem 1rem; background: #fff7e6; border-radius: 4px; margin: 1rem 0; }
    label  { display: block; margin: 0.5rem 0 0.2rem; }
    input, select { padding: 0.3rem; font-size: 1rem; }
    button { padding: 0.3rem 0.7rem; cursor: pointer; }
    button.danger { color: #b00020; }
    .source { font-size: 0.85rem; color: #666; margin-top: 2rem; }
</style>
</head>
<body>

<h1>Members Admin <small>(DevAnswers PDO CRUD demo)</small></h1>

<?php if ($message !== ''): ?>
    <p class="msg"><?= h($message) ?></p>
<?php endif; ?>

<h2>Existing members</h2>
<?php $rows = $members->fetchAll(); ?>
<?php if (count($rows) === 0): ?>
    <p><em>No members yet. Add one below.</em></p>
<?php else: ?>
<table>
    <thead>
        <tr><th>id</th><th>name</th><th>email</th><th>role</th><th>credits</th><th>joined</th><th></th></tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $row): ?>
        <tr>
            <td><?= h((string) $row['id']) ?></td>
            <td><?= h($row['name']) ?></td>
            <td><?= h($row['email']) ?></td>
            <td><?= h($row['role']) ?></td>
            <td><?= h(number_format((float) $row['credits'], 2)) ?></td>
            <td><?= h($row['joined']) ?></td>
            <td>
                <form method="post" class="inline" onsubmit="return confirm('Delete this member?');">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= h((string) $row['id']) ?>">
                    <button class="danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<h2>Add a new member</h2>
<form method="post">
    <input type="hidden" name="action" value="create">
    <label for="name">Name</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" required>

    <label for="role">Role</label>
    <select id="role" name="role">
        <option value="user">user</option>
        <option value="editor">editor</option>
        <option value="admin">admin</option>
    </select>

    <label for="credits">Credits</label>
    <input type="number" id="credits" name="credits" step="0.01" min="0" value="0.00">

    <p><button type="submit">Add member</button></p>
</form>

<p class="source">
    Companion to <a href="https://devanswers.net/php-pdo-crud-prepared-statements/">PHP PDO CRUD with Prepared Statements</a>.
    Source: <a href="https://github.com/devanswers-net/php-crud-prepared-statements">github.com/devanswers-net/php-crud-prepared-statements</a>.
</p>

</body>
</html>
