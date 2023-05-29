<?php
    /*
     * Base Controller
     * Loads the models and views
     */

     class Controller {
        // Load model
        public function model($model) {
            // Reqiore model file
            require_once '../app/models/' . $model . '.php';

            // Instatiate model
            return new $model();
        }

        // Load view
        public function view($view, $data = []) {
            $viewFile = '../app/views/' . $view . '.php';

            if (file_exists($viewFile)) {
                require_once $viewFile;
            } else {
                die('View does not exist');
            }
        }
     }