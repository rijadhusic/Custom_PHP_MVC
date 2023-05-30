<?php
// Load Config
require_once 'config/config.php';

// Autoload Core Libraries
// spl_autoload_register(function($className) {
//     require_once 'libraries/' . $className . '.php';
// });

spl_autoload_register(function($className) {
    // Convert namespace separators to directory separators
    $classFile = str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
    
    // Specify the directories where your classes are located
    $directories = [
        APP_ROOT . '/controllers/',
        APP_ROOT . '/models/',
        APP_ROOT . '/libraries/'
    ];

    // Loop through the directories and check if the class file exists
    foreach ($directories as $directory) {
        $path = $directory . $classFile;
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});