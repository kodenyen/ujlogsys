<?php
namespace App\Core;

class Controller {
    public function render($view, $data = []) {
        // Load settings globally
        $settingModel = new \App\Models\Setting();
        $settings = $settingModel->get();
        $data['settings'] = $settings;

        extract($data);
        $viewPath = __DIR__ . "/../../views/$view.php";
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("View $view not found at $viewPath");
        }
    }

    public function redirect($url) {
        header("Location: " . BASE_URL . $url);
        exit();
    }
}
