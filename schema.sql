-- DevAnswers.net: companion code for:
--   https://devanswers.net/php-mysqli-crud-prepared-statements/
--   https://devanswers.net/php-pdo-crud-prepared-statements/  (sister article)
--
-- Run this once before using any of the CRUD examples:
--   mysql -u devans -p < schema.sql
--
-- Replace 'devans' with your MySQL user. Replace 'devans_app' with whichever
-- database name you prefer; if you change it here, update config.php to match.

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
