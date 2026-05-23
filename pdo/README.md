# PDO CRUD demo

PDO companion code for [PHP PDO CRUD with Prepared Statements](https://devanswers.net/php-pdo-crud-prepared-statements/).

**Coming soon.** This subdirectory will mirror [`../mysqli/`](../mysqli/) using PHP's database-agnostic PDO extension. Same `members` schema (see `../schema.sql`), same CRUD operations, same Irish-name seed data.

## Why two implementations?

`mysqli` is MySQL-only and has specific shortcuts like `execute_query()` in PHP 8.2+. PDO works across MySQL, PostgreSQL, SQLite, and a handful of others, with a slightly different API surface. The cluster repo shows the same operations through both extensions so you can compare them side-by-side and pick the right one for your project.

If you don't know which to pick, the short version:
- **Choose `mysqli`** if your project is MySQL-only and you want the shortest possible CRUD code on modern PHP (8.2+).
- **Choose `pdo`** if your project might switch databases later, or you prefer a more consistent API across drivers.

## See also

- [MySQLi companion code](../mysqli/) (fully implemented now).
- [DevAnswers PDO article](https://devanswers.net/php-pdo-crud-prepared-statements/): the prose tutorial this directory will pair with.
