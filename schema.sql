-- DevAnswers.net: companion code for:
--   https://devanswers.net/php-mysqli-crud-prepared-statements/
--   https://devanswers.net/php-pdo-crud-prepared-statements/
--
-- One-time setup. Run as a MySQL user with database + user creation rights
-- (typically root on a local install):
--   mysql -u root -p < schema.sql
--
-- This script is self-contained. It creates:
--   1. devans_app database (utf8mb4)
--   2. members table (used by both mysqli/ and pdo/ examples)
--   3. devans_user account with CRUD privileges scoped to devans_app
--      -- granted for both 'localhost' (socket) AND '127.0.0.1' (TCP) because
--      -- MySQL treats them as distinct hosts and the PHP examples use
--      -- host=127.0.0.1 in their DSN / connection strings
--
-- After running, edit config.php with the matching credentials and you're done.
-- No further DB admin is required.

CREATE DATABASE IF NOT EXISTS devans_app
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE devans_app;

CREATE TABLE IF NOT EXISTS members (
    id       INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name     VARCHAR(100) NOT NULL,
    email    VARCHAR(120) NOT NULL UNIQUE,
    role     ENUM('user', 'editor', 'admin') NOT NULL DEFAULT 'user',
    credits  DECIMAL(8,2) NOT NULL DEFAULT 0.00,
    joined   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dedicated app user with privileges scoped to devans_app only.
-- Both 'localhost' and '127.0.0.1' grants are needed because MySQL treats
-- them as distinct hosts: 'localhost' resolves to the Unix socket,
-- '127.0.0.1' resolves to TCP loopback. The PHP examples use TCP so we
-- grant for both to keep things working regardless of how PHP connects.
CREATE USER IF NOT EXISTS 'devans_user'@'localhost' IDENTIFIED BY 'devans_pass';
CREATE USER IF NOT EXISTS 'devans_user'@'127.0.0.1' IDENTIFIED BY 'devans_pass';
GRANT SELECT, INSERT, UPDATE, DELETE ON devans_app.* TO 'devans_user'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON devans_app.* TO 'devans_user'@'127.0.0.1';
FLUSH PRIVILEGES;
