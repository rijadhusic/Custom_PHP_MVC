<?php
/*
* Base Controller
* Loads the models and views
*/

class Controller {
    // Load model
    public function model($model) {
        // Require model file
        $modelFile = '../app/models/' . $model . '.php';
        if (file_exists($modelFile)) {
            require_once $modelFile;
            // Instantiate model
            return new $model();
        } else {
            die('Model does not exist');
        }
    }

    // Load view
    public function view($view, $data = []) {
        $viewFile = '../app/views/' . $view . '.php';

        if (file_exists($viewFile)) {
            // Extract the data array into variables for easier access in the view
            extract($data);

            require_once $viewFile;
        } else {
            die('View does not exist');
        }
    }
}
    