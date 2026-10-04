<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/db.php';
?>
<?php
/**
 * Dashboard Router & Smart Role Dispatcher
 * Automatically routes users to their role-specific dashboard:
 * - Administrators -> Admin Dashboard (pages/admin-dashboard.php)
 * - Warehouse Staff -> Staff Dashboard (pages/staff-dashboard.php)
 */
require_once __DIR__ . '/../config/db.php';

if (isAdmin()) {
    header('Location: ' . url('pages/admin-dashboard.php'));
    exit;
} else {
    header('Location: ' . url('pages/staff-dashboard.php'));
    exit;
}
