<?php
/**
 * Authentication Check Middleware
 * Include at the top of protected pages to verify session
 */
require_once __DIR__ . '/../config/config.php';

if (!isLoggedIn()) {
    setFlash('warning', 'Please sign in to access the system.');
    header('Location: ' . url('pages/login.php'));
    exit;
}
