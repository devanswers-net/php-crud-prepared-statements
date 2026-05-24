# PHP CRUD with prepared statements: MySQLi + PDO

Working companion code for two DevAnswers tutorials:

- [PHP MySQLi Tutorial: CRUD Operations with Prepared Statements](https://devanswers.net/php-mysqli-crud-prepared-statements/) → [`mysqli/`](mysqli/)
- [PHP PDO Tutorial: CRUD Operations with Prepared Statements](https://devanswers.net/php-pdo-crud-prepared-statements/) → [`pdo/`](pdo/)

Both implementations use the same `members` schema and the same CRUD operations (Create / Read / Update / Delete) plus a transaction example, so you can read either article and run the matching code without translating between APIs.

## What you need first

If you don't already have PHP + MySQL installed, follow one of our setup guides:

- [PHP with Apache on Debian 12](https://devanswers.net/how-to-install-php-with-apache-on-debian-12/)
- [PHP-FPM with nginx on Ubuntu 26.04](https://devanswers.net/how-to-install-php-fpm-with-nginx-on-ubuntu-26-04/)
- [PHP-FPM with nginx on Debian 13](https://devanswers.net/how-to-install-php-fpm-with-nginx-on-debian-13/)

Minimum: **PHP 8.1+** with the `pdo_mysql` and `mysqli` extensions, plus **MySQL 8.0+** or **MariaDB 10.5+** running locally.

## Download

Two options:

- **Have Git?** Clone with `git clone https://github.com/devanswers-net/php-crud-prepared-statements.git`
- **No Git?** Click the green **`Code`** button at the top of this page → **Download ZIP** → unzip wherever you like

## Setup (one-time, 3 commands)

From the repo root:

```bash
# 1. Create the database, table, and devans_user account in one go.
#    Run as MySQL root (the only step that needs admin rights).
mysql -u root -p < schema.sql

# 2. Copy the credentials template. Defaults match what schema.sql just created,
#    so you don't have to edit anything unless you want to.
cp config.sample.php config.php

# 3. (Optional) Pre-populate with 3 example members so the HTML UI isn't empty.
mysql -u devans_user -p devans_app < seed.sql   # password: devans_pass
```

That's it. The database is ready and the code knows how to reach it.

## Try it

Start PHP's built-in webserver from the repo root and visit the HTML admin UI:

```bash
php -S localhost:8000
```

Then open one of these in your browser:

- **PDO version:** http://localhost:8000/pdo/index.php
- **MySQLi version:** http://localhost:8000/mysqli/index.php

You'll see the members list with an add/edit/delete form. Click around. Every interaction runs real prepared-statement code matching what the articles walk through.

## What's in here

```
.
├── README.md                  (this file)
├── LICENSE                    (MIT, use it however)
├── schema.sql                 (DB + table + devans_user, used by both mysqli/ and pdo/)
├── seed.sql                   (optional Irish-name seed data)
├── config.sample.php          (credentials template, copy to config.php)
├── connect.php                (shared bootstrap)
├── mysqli/
│   ├── README.md              (per-API notes)
│   ├── index.php              (HTML admin UI)
│   ├── execute_query/         (PHP 8.2+ shortcut: 5 files, one per operation)
│   └── prepare_bind_execute/  (PHP 8.1 fallback: prepare / bind_param / execute)
└── pdo/
    ├── README.md              (per-API notes)
    ├── connect.php            (PDO-specific bootstrap)
    └── index.php              (HTML admin UI)
```

## License

MIT. See [LICENSE](LICENSE). Use it, fork it, ship it.

## Why a paired repo?

`mysqli` and `pdo` are sister APIs in PHP: same SQL, same CRUD semantics, different surface. Keeping both implementations under one repo means you can compare them in-place rather than juggling two tabs. Shared `schema.sql`, `seed.sql`, and `config.sample.php` live at the root so neither implementation duplicates them.

If you only care about one API, [`mysqli/`](mysqli/) or [`pdo/`](pdo/) are self-contained. You don't have to read the other.
