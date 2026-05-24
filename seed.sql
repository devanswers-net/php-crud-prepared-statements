-- DevAnswers.net: optional seed data
--   https://devanswers.net/php-mysqli-crud-prepared-statements/
--   https://devanswers.net/php-pdo-crud-prepared-statements/
--
-- Optional. Loads 3 example members so the HTML UI (mysqli/index.php or
-- pdo/index.php) isn't empty when you first open it. Skip this step if
-- you'd rather see the empty-table state and add members yourself via
-- the form.
--
-- Run as devans_user (credentials match what schema.sql created):
--   mysql -u devans_user -p devans_app < seed.sql   # password: devans_pass

USE devans_app;

INSERT INTO members (name, email, role, credits) VALUES
    ('Declan Walsh', 'declan@devanswers.test', 'editor', 50.00),
    ('Fiona Doyle',  'fiona@devanswers.test',  'user',   75.00),
    ('Ronan Kelly',  'ronan@devanswers.test',  'admin',  200.00);
