<?php
// DevAnswers.net: credentials template
//   https://devanswers.net/php-mysqli-crud-prepared-statements/
//
// First-time setup:
//   1. Copy this file to config.php:    cp config.sample.php config.php
//   2. Edit config.php with your real MySQL credentials.
//   3. config.php is in .gitignore so credentials never get committed.

return [
    'db_host' => '127.0.0.1',
    'db_user' => 'devans',      // your MySQL user
    'db_pass' => 'your-password-here',
    'db_name' => 'devans_app',  // matches schema.sql
];
