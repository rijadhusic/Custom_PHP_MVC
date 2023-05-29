<?php
 /*
 * App Core Class
 * Creates URL & loads core controller
 * URL FORMAT - /controller/method/params
 */

 class Core {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct() {
        //print_r($this->getUrl());
        $url = $this->getUrl();
        $url = $this->sanitizeUrl($url);

        // Look into controllers for first value
        if(isset($url[0]) && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            // If exists, set as current controller
            $this->currentController = ucwords($url[0]);
            // Unset 0 Index
            unset($url[0]);
        }
        try {
            // Require the controller
            require_once '../app/controllers/' . $this->currentController . '.php';

            // Instantiate the controller class
            $this->currentController = new $this->currentController;

            // Check for second part of the URL
            if(isset($url[0]) && method_exists($this->currentController,$url[0])) {
                $this->currentMethod = $url[0];
                // Unset 1 Index
                unset($url[0]);
            } elseif (isset($url[1]) && method_exists($this->currentController,$url[1])) {
                $this->currentMethod = $url[1];
                // Unset 1 Index
                unset($url[1]);
            }

            // Get parameters
            $this->params = $url ? array_values($url) : [];

            // Call the controller method with parameters
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        } catch (Exception $e) {
            // Handle the exception
            $this->showError($e->getMessage());
        }
    }

    public function showError($message) {
        // Set the HTTP response code to indicate an error (e.g., 500 for internal server error)
        http_response_code(500);
    
        // Display the error message in a nicely formatted way
        echo '<pre>';
        echo '<strong>Error:</strong> ' . $message . "\n";
        echo '</pre>';
    
        // You may also log the error or perform any other necessary actions
    }
    
    public function sanitizeUrl($url) {
        // Check if $url is null
        if ($url === null) {
            return [];
        }
        
        // Sanitize each part of the URL
        $sanitizedUrl = [];
        foreach ($url as $part) {
            $sanitizedUrl[] = filter_var($part, FILTER_SANITIZE_STRING);
        }

        return $sanitizedUrl;
    }

    public function getUrl(){
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
 }
 