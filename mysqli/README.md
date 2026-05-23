# MySQLi CRUD demo

Companion code for [PHP MySQLi CRUD with Prepared Statements](https://devanswers.net/php-mysqli-crud-prepared-statements/).

## Quick start

From the repo root:

```bash
# 1. Create the database + members table (one-time).
mysql -u devans -p < schema.sql

# 2. (Optional) Pre-populate with 3 example members for the HTML UI.
mysql -u devans -p devans_app < seed.sql

# 3. Copy the credentials template + edit your real values.
cp config.sample.php config.php
$EDITOR config.php

# 4a. Run the end-to-end CLI demo (skip step 2 first; the demo seeds its own data).
php mysqli/cli_demo.php

# 4b. OR launch the HTML UI in a browser.
php -S localhost:8000
# then visit http://localhost:8000/mysqli/index.php
```

## Files

| Path | What |
|---|---|
| `cli_demo.php` | Runs INSERT, SELECT, UPDATE, DELETE, TRANSACTIONS end-to-end and prints output. Mirrors the article's example flow. |
| `index.php` | Vanilla HTML + PHP UI. List view + add-member form + delete buttons. No framework. |
| `execute_query/` | PHP 8.2+ shortcut. One `execute_query()` call per operation. One file per CRUD operation plus `transactions.php`. |
| `prepare_bind_execute/` | PHP 8.1 fallback. Use `prepare()` + `bind_param()` + `execute()` + `get_result()` chain. INSERT + SELECT examples (the same pattern applies to UPDATE/DELETE). |

## Which API version to use

- **PHP 8.2 or later** (Ubuntu 24.04+, Debian 12+): use `execute_query/`.
- **PHP 8.1** (Ubuntu 22.04): use `prepare_bind_execute/`.

`execute_query()` is shorter; the older chain still works on every PHP version since 5.x and is what most existing codebases use.

## Notes

- Every example uses `mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT)` (set in `connect.php`), so errors throw `mysqli_sql_exception` rather than silently returning `false`. This is the recommended pattern on PHP 8.x.
- `config.php` is gitignored, so your credentials never get committed.
- The `members` table uses Irish-name seed data (Maeve Gallagher, Declan Walsh, Fiona Doyle, Ronan Kelly) consistent with the article body.

## See also

- Sister article: [PHP PDO CRUD with Prepared Statements](https://devanswers.net/php-pdo-crud-prepared-statements/). Same operations using PHP's database-agnostic PDO extension. PDO companion code is in [`../pdo/`](../pdo/) (coming soon).
