<?php
/**
 * Dashboard & Analytics View
 */
require_once __DIR__ . '/../includes/auth_check.php';

$pageTitle = 'Inventory Dashboard';
$extraJs = 'dashboard.js';
require_once __DIR__ . '/../includes/header.php';

// Fetch Dashboard Metrics
try {
    // 1. Total Products
    $prodCountStmt = $pdo->query("SELECT COUNT(*) FROM products");
    $totalProducts = (int)$prodCountStmt->fetchColumn();

    // 2. Inventory Valuation (Selling Value & Cost Value)
    $valStmt = $pdo->query("SELECT SUM(quantity * unit_price) AS total_val, SUM(quantity * cost_price) AS total_cost FROM products");
    $valData = $valStmt->fetch();
    $totalValuation = (float)($valData['total_val'] ?? 0);
    $totalCostVal   = (float)($valData['total_cost'] ?? 0);

    // 3. Low Stock Items (Quantity <= min_threshold AND Quantity > 0)
    $lowStockStmt = $pdo->query("SELECT COUNT(*) FROM products WHERE quantity > 0 AND quantity <= min_threshold");
    $lowStockCount = (int)$lowStockStmt->fetchColumn();

    // 4. Out of Stock Items (Quantity = 0)
    $outOfStockStmt = $pdo->query("SELECT COUNT(*) FROM products WHERE quantity = 0");
    $outOfStockCount = (int)$outOfStockStmt->fetchColumn();

    // 5. Recent 8 Stock Transactions
    $txStmt = $pdo->query("SELECT st.*, p.name AS product_name, p.sku, u.full_name AS user_name 
        FROM stock_transactions st
        JOIN products p ON st.product_id = p.id
        LEFT JOIN users u ON st.user_id = u.id
        ORDER BY st.created_at DESC LIMIT 8");
    $recentTransactions = $txStmt->fetchAll();

    // 6. Items requiring urgent replenishment
    $urgentStmt = $pdo->query("SELECT p.*, c.name AS category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.quantity <= p.min_threshold 
        ORDER BY p.quantity ASC LIMIT 5");
    $urgentItems = $urgentStmt->fetchAll();

} catch (PDOException $e) {
    error_log("Dashboard query error: " . $e->getMessage());
    $totalProducts = $totalValuation = $lowStockCount = $outOfStockCount = 0;
    $recentTransactions = [];
    $urgentItems = [];
}
?>

<!-- Quick Actions -->
<div class="quick-actions-bar">
    <a href="<?= url('pages/stock-in.php') ?>" class="btn btn-success">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <polyline points="19 12 12 19 5 12"></polyline>
        </svg>
        <span>Stock In (Intake)</span>
    </a>

    <a href="<?= url('pages/stock-out.php') ?>" class="btn btn-danger">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="19" x2="12" y2="5"></line>
            <polyline points="5 12 12 5 19 12"></polyline>
        </svg>
        <span>Stock Out (Dispatch)</span>
    </a>

    <a href="<?= url('pages/product-add.php') ?>" class="btn btn-primary">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="16"></line>
            <line x1="8" y1="12" x2="16" y2="12"></line>
        </svg>
        <span>Add New Product</span>
    </a>

    <a href="<?= url('pages/reports.php') ?>" class="btn btn-outline" style="margin-left: auto;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="20" x2="18" y2="10"></line>
            <line x1="12" y1="20" x2="12" y2="4"></line>
            <line x1="6" y1="20" x2="6" y2="14"></line>
        </svg>
        <span>View Reports</span>
    </a>
</div>

<!-- Metrics Cards Grid -->
<div class="metrics-grid">
    <div class="metric-card">
        <div class="metric-data">
            <span class="metric-label">Total Products</span>
            <span class="metric-value"><?= number_format($totalProducts) ?></span>
        </div>
        <div class="metric-icon primary">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <path d="M16 10a4 4 0 0 1-8 0"></path>
            </svg>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-data">
            <span class="metric-label">Inventory Valuation</span>
            <span class="metric-value"><?= formatCurrency($totalValuation) ?></span>
        </div>
        <div class="metric-icon success">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
     stroke="currentColor" stroke-width="2"
     stroke-linecap="round" stroke-linejoin="round">

  <!-- Top bars -->
  <line x1="6" y1="5" x2="18" y2="5"></line>
  <line x1="6" y1="9" x2="16" y2="9"></line>

  <!-- Rupee curve -->
  <path d="M9 5c3 0 6 1.5 6 4s-3 4-6 4h-2"></path>

  <!-- Diagonal stroke -->
  <path d="M9 13l7 7"></path>

</svg>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-data">
            <span class="metric-label">Low Stock Alerts</span>
            <span class="metric-value"><?= number_format($lowStockCount) ?></span>
        </div>
        <div class="metric-icon warning">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                <line x1="12" y1="9" x2="12" y2="13"></line>
                <line x1="12" y1="17" x2="12.01" y2="17"></line>
            </svg>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-data">
            <span class="metric-label">Out of Stock</span>
            <span class="metric-value"><?= number_format($outOfStockCount) ?></span>
        </div>
        <div class="metric-icon danger">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
            </svg>
        </div>
    </div>
</div>

<!-- Dashboard 2-column Content -->
<div class="dashboard-grid">
    <!-- Left: Recent Movement Ledger -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Recent Stock Activity</h2>
            <a href="<?= url('pages/stock-history.php') ?>" class="btn btn-sm btn-outline">View Full History &rarr;</a>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Product</th>
                            <th>Type</th>
                            <th>Qty</th>
                            <th>Balance</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentTransactions)): ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                                    No inventory movements recorded yet.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recentTransactions as $tx): ?>
                                <tr>
                                    <td><small><?= date('M d, H:i', strtotime($tx['created_at'])) ?></small></td>
                                    <td>
                                        <strong><?= htmlspecialchars($tx['product_name']) ?></strong>
                                        <div style="font-size: 0.75rem; color: var(--text-muted);"><?= htmlspecialchars($tx['sku']) ?></div>
                                    </td>
                                    <td>
                                        <span class="badge <?= $tx['type'] === 'IN' ? 'badge-movement-in' : 'badge-movement-out' ?>">
                                            <?= $tx['type'] === 'IN' ? '+ IN' : '- OUT' ?>
                                        </span>
                                    </td>
                                    <td><strong><?= number_format($tx['quantity']) ?></strong></td>
                                    <td><small><?= number_format($tx['balance_after']) ?></small></td>
                                    <td><small><?= htmlspecialchars($tx['user_name'] ?? 'System') ?></small></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right: Low Stock Warnings -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Reorder Attention</h2>
            <span class="badge badge-warning"><?= count($urgentItems) ?> Items</span>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Stock</th>
                            <th>Min</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($urgentItems)): ?>
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                                    All inventory levels are healthy!
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($urgentItems as $item): ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($item['name']) ?></strong>
                                        <div style="font-size: 0.75rem; color: var(--text-muted);"><?= htmlspecialchars($item['sku']) ?></div>
                                    </td>
                                    <td>
                                        <span class="stock-status-pill <?= $item['quantity'] == 0 ? 'outofstock' : 'lowstock' ?>">
                                            <?= $item['quantity'] ?> <?= htmlspecialchars($item['unit_of_measure']) ?>
                                        </span>
                                    </td>
                                    <td><?= $item['min_threshold'] ?></td>
                                    <td>
                                        <a href="<?= url('pages/stock-in.php?product_id=' . $item['id']) ?>" class="btn btn-sm btn-success" title="Restock">
                                            + In
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
