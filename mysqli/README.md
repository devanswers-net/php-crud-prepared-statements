# MySQLi CRUD demo

Companion code for [PHP MySQLi Tutorial: CRUD Operations with Prepared Statements](https://devanswers.net/php-mysqli-crud-prepared-statements/).

## Quick start

From the repo root:

```bash
# 1. Create the database + table + devans_user account (one-time, needs root).
mysql -u root -p < schema.sql

# 2. (Optional) Pre-populate with 3 example members so the HTML UI isn't empty.
mysql -u devans_user -p devans_app < seed.sql   # password: devans_pass

# 3. Copy the credentials template. Defaults match what schema.sql created;
#    no edit needed unless you want to use a different user.
cp config.sample.php config.php

# 4. Launch the HTML UI in your browser.
php -S localhost:8000
# then visit http://localhost:8000/mysqli/index.php
```

## Files

| Path | What |
|---|---|
| `index.php` | Vanilla HTML + PHP UI. List view + add-member form + edit/delete buttons. No framework. |
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

- Sister article: [PHP PDO Tutorial: CRUD Operations with Prepared Statements](https://devanswers.net/php-pdo-crud-prepared-statements/). Same operations using PHP's database-agnostic PDO extension. PDO companion code is in [`../pdo/`](../pdo/).
