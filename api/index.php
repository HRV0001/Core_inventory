<?php
// Enable error reporting to catch database/syntax issues
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get the requested URI path
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Route root / or /index.php to /pages/dashboard.php
if ($requestUri === '/' || $requestUri === '/index.php' || $requestUri === '/dashboard') {
    require __DIR__ . '/../pages/dashboard.php';
    exit();
}

// Target file path mapping
$filePath = __DIR__ . '/..' . $requestUri;

// If requested PHP file exists, require it
if (file_exists($filePath) && is_file($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
    require $filePath;
    exit();
}

// Serve static assets (CSS, JS, images) if requested
if (file_exists($filePath) && is_file($filePath)) {
    $mimeType = mime_content_type($filePath);
    header("Content-Type: " . $mimeType);
    readfile($filePath);
    exit();
}

// Fallback to dashboard
require __DIR__ . '/../pages/dashboard.php';
?>