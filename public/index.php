<?php
// Load configuration
require_once __DIR__ . '/../config/config.php';

// Simple Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Start session
session_start();

// Initialize Router
$router = new \App\Core\Router();

// Define Routes
$router->add('login', 'AuthController', 'login');
$router->add('logout', 'AuthController', 'logout');
$router->add('admin/dashboard', 'AdminController', 'index');
$router->add('admin/users', 'AdminController', 'users');
$router->add('admin/departments', 'AdminController', 'departments');
$router->add('admin/sessions', 'AdminController', 'sessions');
$router->add('admin/logConfig', 'AdminController', 'logConfig');
$router->add('admin/reports', 'AdminController', 'reports');
$router->add('admin/exportCSV', 'AdminController', 'exportCSV');
$router->add('admin/settings', 'AdminController', 'settings');
$router->add('student/dashboard', 'StudentController', 'index');
$router->add('student/getSessions', 'StudentController', 'getSessions');
$router->add('student/getActivityTypes', 'StudentController', 'getActivityTypes');
$router->add('student/getTypeFields', 'StudentController', 'getTypeFields');
$router->add('student/submitLog', 'StudentController', 'submitLog');
$router->add('consultant/dashboard', 'ConsultantController', 'index');
$router->add('consultant/confirmAttendance', 'ConsultantController', 'confirmAttendance');
$router->add('consultant/confirmAllAttendance', 'ConsultantController', 'confirmAllAttendance');
$router->add('consultant/approveLog', 'ConsultantController', 'approveLog');
$router->add('consultant/reports', 'ConsultantController', 'reports');

// Get URL and dispatch
$url = '';
if (isset($_GET['url'])) {
    $url = trim($_GET['url'], '/');
} else {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $url = trim($path, '/');
}

// Redirect root to login if no path
if ($url === '') {
    $url = 'login';
}

$router->dispatch($url);
