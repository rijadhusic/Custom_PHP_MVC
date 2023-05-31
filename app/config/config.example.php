<?php
// DB Parameters
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'php_project');

// PDO Error Mode
define('PDO_ERROR_MODE', PDO::ERRMODE_EXCEPTION);

// App Configuration
define('APP_ROOT', dirname(dirname(__FILE__)));
define('URL_ROOT', 'http://localhost/project');
define('SITE_NAME', 'CustomMVC');

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', true);

// Set Default Timezone
date_default_timezone_set('UTC');