<?php
// DB Parameters
define('DB_HOST', 'localhost');
define('DB_USER', '_YOUR_USER_');
define('DB_PASSWORD', '_YOUR_PASSWORD_');
define('DB_NAME', '_YOUR_DB_NAME_');

// PDO Error Mode
define('PDO_ERROR_MODE', PDO::ERRMODE_EXCEPTION);

// App Configuration
define('APP_ROOT', dirname(dirname(__FILE__)));
define('URL_ROOT', '_YOUR_URL_');
define('SITE_NAME', '_YOUR_SITE_NAME_');

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', true);

// Set Default Timezone
date_default_timezone_set('UTC');