-- DevAnswers.net: optional seed data
--   https://devanswers.net/php-crud-prepared-statements/
--
-- Optional. Loads 3 example members for immediate use of mysqli/index.php
-- (the HTML UI demo). Skip if you'd rather run cli_demo.php first, which
-- starts from an empty table and inserts its own example members.
--
-- Run:
--   mysql -u devans -p devans_app < seed.sql

USE devans_app;

INSERT INTO members (name, email, role, credits) VALUES
    ('Declan Walsh', 'declan@devanswers.test', 'editor', 50.00),
    ('Fiona Doyle',  'fiona@devanswers.test',  'user',   75.00),
    ('Ronan Kelly',  'ronan@devanswers.test',  'admin',  200.00);
