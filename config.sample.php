<?php
// DevAnswers.net: credentials template
//   https://devanswers.net/php-mysqli-crud-prepared-statements/
//   https://devanswers.net/php-pdo-crud-prepared-statements/
//
// First-time setup (one-time):
//   1. Copy this file to config.php:    cp config.sample.php config.php
//   2. Edit config.php if your MySQL credentials differ from the defaults.
//   3. config.php is in .gitignore so credentials never get committed.
//
// The default values below match the user that schema.sql creates
// (devans_user / devans_pass). If you ran schema.sql with `mysql -u root -p < schema.sql`,
// nothing needs to change; config.php will work as-is.

return [
    'db_host' => '127.0.0.1',
    'db_user' => 'devans_user',
    'db_pass' => 'devans_pass',
    'db_name' => 'devans_app',
];
