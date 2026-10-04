<?php
/**
 * Global Sidebar Navigation Component
 */
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<aside class="sidebar" id="appSidebar">
    <div class="sidebar-brand">
        <a href="<?= url('pages/dashboard.php') ?>" class="brand-link">
            <div class="brand-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
            </div>
            <span class="brand-text">Core<strong>Inventory</strong></span>
        </a>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-title">MAIN MENU</div>
        <ul class="nav-list">
            <li class="nav-item">
                <a href="<?= url('pages/dashboard.php') ?>" class="nav-link <?= $currentPage === 'dashboard.php' ? 'active' : '' ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>

            <div class="nav-section-title">INVENTORY</div>
            <li class="nav-item">
                <a href="<?= url('pages/products.php') ?>" class="nav-link <?= in_array($currentPage, ['products.php', 'product-edit.php']) ? 'active' : '' ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                    <span>Products List</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= url('pages/product-add.php') ?>" class="nav-link <?= $currentPage === 'product-add.php' ? 'active' : '' ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="16"></line>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>
                    <span>Add Product</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= url('pages/categories.php') ?>" class="nav-link <?= $currentPage === 'categories.php' ? 'active' : '' ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                        <line x1="7" y1="7" x2="7.01" y2="7"></line>
                    </svg>
                    <span>Categories</span>
                </a>
            </li>

            <div class="nav-section-title">STOCK OPERATIONS</div>
            <li class="nav-item">
                <a href="<?= url('pages/stock-in.php') ?>" class="nav-link <?= $currentPage === 'stock-in.php' ? 'active' : '' ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <polyline points="19 12 12 19 5 12"></polyline>
                    </svg>
                    <span>Stock In (Intake)</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= url('pages/stock-out.php') ?>" class="nav-link <?= $currentPage === 'stock-out.php' ? 'active' : '' ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="19" x2="12" y2="5"></line>
                        <polyline points="5 12 12 5 19 12"></polyline>
                    </svg>
                    <span>Stock Out (Dispatch)</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= url('pages/stock-history.php') ?>" class="nav-link <?= $currentPage === 'stock-history.php' ? 'active' : '' ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span>Movement History</span>
                </a>
            </li>

            <div class="nav-section-title">PARTNERS & REPORTS</div>
            <li class="nav-item">
                <a href="<?= url('pages/suppliers.php') ?>" class="nav-link <?= $currentPage === 'suppliers.php' ? 'active' : '' ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <span>Suppliers</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= url('pages/reports.php') ?>" class="nav-link <?= $currentPage === 'reports.php' ? 'active' : '' ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="20" x2="18" y2="10"></line>
                        <line x1="12" y1="20" x2="12" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="14"></line>
                    </svg>
                    <span>Reports & Alerts</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <div class="system-status">
            <span class="status-indicator online"></span>
            <span>Database Connected</span>
        </div>
    </div>
</aside>
