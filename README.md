# PHP CRUD with prepared statements: MySQLi + PDO

Working companion code for two DevAnswers tutorials:

- [PHP MySQLi CRUD with Prepared Statements](https://devanswers.net/php-mysqli-crud-prepared-statements/): [`mysqli/`](mysqli/)
- [PHP PDO CRUD with Prepared Statements](https://devanswers.net/php-pdo-crud-prepared-statements/): [`pdo/`](pdo/) *(coming soon)*

Both implementations use the same `members` schema and the same set of CRUD operations (Create / Read / Update / Delete) plus a transaction example, so you can read either article and run the matching code without translating between APIs.

## What's in here

```
.
├── README.md                  (this file)
├── LICENSE                    (MIT)
├── schema.sql                 (members table, used by both mysqli/ and pdo/)
├── seed.sql                   (optional Irish-name seed data: Declan / Fiona / Ronan)
├── config.sample.php          (credentials template, to be copied to config.php)
├── connect.php                (shared mysqli bootstrap)
├── mysqli/
│   ├── README.md              (per-API quick-start)
│   ├── cli_demo.php           (end-to-end CLI walkthrough)
│   ├── index.php              (HTML form + list view)
│   ├── execute_query/         (PHP 8.2+ shortcut: 5 files, one per operation)
│   └── prepare_bind_execute/  (PHP 8.1 fallback: prepare / bind_param / execute)
└── pdo/
    └── README.md              (placeholder for PDO; implementation lands with article 304 refresh)
```

## Setup (one-time)

```bash
# 1. Create the database + members table.
mysql -u devans -p < schema.sql

# 2. Copy the credentials template and edit your real values.
cp config.sample.php config.php
$EDITOR config.php

# 3. (Optional) Pre-populate with 3 example members for the HTML UI.
mysql -u devans -p devans_app < seed.sql
```

Replace `devans` with your MySQL user. `config.php` is gitignored so credentials never get committed.

## Run the demo

Two entry paths, pick one:

```bash
# Path A. CLI walkthrough (matches the article's INSERT, SELECT, UPDATE, DELETE, TRANSACTIONS flow):
php mysqli/cli_demo.php

# Path B. HTML UI:
php -S localhost:8000
# Visit http://localhost:8000/mysqli/index.php
```

## Requirements

- PHP 8.1 or later (Ubuntu 22.04 / Debian 12 onwards; the `execute_query()` shortcut requires 8.2+).
- MySQL 8.0+ or MariaDB 10.6+ on the same host or reachable over TCP.
- `mysqli` and `mysqlnd` extensions enabled (default on Ubuntu / Debian apt installs).

## License

MIT. See [LICENSE](LICENSE). Use it, fork it, ship it.

## Why a cluster repo?

`mysqli` and `pdo` are sister APIs in PHP: same SQL, same CRUD semantics, different surface. Keeping both implementations under one repo means readers can compare them in-place rather than juggling two tabs. The shared `schema.sql`, `seed.sql`, and `config.sample.php` live at the root so neither implementation duplicates them.

If you only care about one API, [`mysqli/`](mysqli/) or [`pdo/`](pdo/) are self-contained, so you don't have to read the other.
