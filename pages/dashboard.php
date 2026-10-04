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
