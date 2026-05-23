# PDO CRUD demo

Companion code for [PHP PDO CRUD with Prepared Statements](https://devanswers.net/php-pdo-crud-prepared-statements/).

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
php pdo/cli_demo.php

# 4b. OR launch the HTML UI in a browser.
php -S localhost:8000
# then visit http://localhost:8000/pdo/index.php
```

## Files

| Path | What |
|---|---|
| `connect.php` | Shared PDO bootstrap. Sets `ATTR_ERRMODE = EXCEPTION`, `ATTR_DEFAULT_FETCH_MODE = FETCH_ASSOC`, `ATTR_EMULATE_PREPARES = false`. |
| `cli_demo.php` | Runs INSERT, SELECT, UPDATE, DELETE, TRANSACTIONS end-to-end and prints output. Mirrors the article's example flow using named placeholders. |
| `index.php` | Vanilla HTML + PHP UI. List view + add-member form + delete buttons. No framework. |

## Notes

- All examples use **named placeholders** (`:name`, `:email`) which PDO supports out of the box. Positional `?` placeholders also work; named placeholders read more clearly with multiple parameters.
- `PDO::ERRMODE_EXCEPTION` is the default since PHP 8.0, but `connect.php` sets it explicitly so the intent is visible in the file. Pre-8.0 you'd have needed this line or PDO would silently return `false` on errors.
- `PDO::ATTR_EMULATE_PREPARES = false` forces real server-side prepared statements (MySQL `COM_STMT_PREPARE` / `COM_STMT_EXECUTE`), not client-side string substitution. This is the safer default.
- `config.php` is gitignored, so your credentials never get committed.
- The `members` table uses Irish-name seed data (Maeve Gallagher, Declan Walsh, Fiona Doyle, Ronan Kelly) consistent with the article body.

## When to choose PDO over MySQLi

- **Multi-database project**: PDO talks to MySQL, PostgreSQL, SQLite, SQL Server, and 8+ other drivers with the same API. MySQLi only talks to MySQL/MariaDB.
- **Named placeholders preferred**: `:email` reads more clearly than `?` with many parameters.
- **Single consistent API**: if your team already knows PDO from another project, no reason to learn MySQLi for this one.

The sister [`../mysqli/`](../mysqli/) directory shows the same CRUD operations using PHP's MySQL-specific extension; pick whichever fits your project.

## See also

- Sister article: [PHP MySQLi CRUD with Prepared Statements](https://devanswers.net/php-mysqli-crud-prepared-statements/). Same operations using PHP's MySQL-only extension; covers the `execute_query()` shortcut available in PHP 8.2+. MySQLi companion code is in [`../mysqli/`](../mysqli/).
