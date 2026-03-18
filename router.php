<?php
/**
 * Router script for the PHP built-in server.
 * Manually serves static assets from the /public folder.
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// Define the absolute path to the public directory
$publicDir = __DIR__ . DIRECTORY_SEPARATOR . 'public';
$filePath = $publicDir . $uri;

// 1. If the requested URI is an existing file inside the public folder, serve it
if ($uri !== '/' && file_exists($filePath) && is_file($filePath)) {
    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    $mimes = [
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png'  => 'image/png',
        'gif'  => 'image/gif',
        'svg'  => 'image/svg+xml',
        'css'  => 'text/css',
        'js'   => 'application/javascript',
        'ico'  => 'image/x-icon'
    ];
    
    if (isset($mimes[$extension])) {
        header("Content-Type: " . $mimes[$extension]);
    }
    
    // Explicitly read and output the file content
    readfile($filePath);
    exit;
}

// 2. Otherwise, route the request to public/index.php
$_GET['url'] = ltrim($uri, '/');
require_once $publicDir . DIRECTORY_SEPARATOR . 'index.php';
