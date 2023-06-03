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
        $url = $this->getUrl();
        $url = $this->sanitizeUrl($url);

        try {
            // Look into controllers for the first value
            if (!empty($url[0]) && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
                $this->currentController = ucwords($url[0]);
                unset($url[0]);
            }

            // Require the controller
            require_once '../app/controllers/' . $this->currentController . '.php';

            // Instantiate the controller class
            $this->currentController = new $this->currentController;

            // Check for the second part of the URL
            if (!empty($url[1]) && method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }

            // Get parameters
            $this->params = $url ? array_values($url) : [];

            // Call the controller method with parameters
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        } catch (Throwable $e) {
            // Handle the exception
            $this->showError($e->getMessage());
        }
    }

    public function showError($message) {
        http_response_code(500);

        echo '<pre>';
        echo '<strong>Error:</strong> ' . $message . "\n";
        echo '</pre>';

        // You may also log the error or perform any other necessary actions
    }

    public function sanitizeUrl($url) {
        return array_map(function ($part) {
            return filter_var($part, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }, $url);
    }

    public function getUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }

        return [];
    }
}
