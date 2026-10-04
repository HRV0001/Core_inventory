<?php
/**
 * Categories Management View
 */
require_once __DIR__ . '/../includes/auth_check.php';

$pageTitle = 'Product Categories';
require_once __DIR__ . '/../includes/header.php';

// Fetch categories with product counts
$query = "SELECT c.*, COUNT(p.id) AS product_count 
          FROM categories c 
          LEFT JOIN products p ON c.id = p.category_id 
          GROUP BY c.id 
          ORDER BY c.name ASC";
$categories = $pdo->query($query)->fetchAll();
?>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem; align-items: start;">
    <!-- Add Category Form -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Add New Category</h2>
        </div>
        <div class="card-body">
            <form action="<?= url('api/categories.php?action=create') ?>" method="POST">
                <div class="form-group">
                    <label class="form-label required" for="cat_name">Category Name</label>
                    <input type="text" id="cat_name" name="name" class="form-control" placeholder="e.g. Storage & Shelving" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="cat_desc">Description</label>
                    <textarea id="cat_desc" name="description" class="form-control" rows="3" placeholder="Brief description of items in this category..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Create Category</button>
            </form>
        </div>
    </div>

    <!-- Category List Table -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Existing Categories (<?= count($categories) ?>)</h2>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>Items Linked</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($categories)): ?>
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                                    No categories created yet.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($categories as $cat): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($cat['name']) ?></strong></td>
                                    <td><small style="color: var(--text-muted);"><?= htmlspecialchars($cat['description'] ?? 'No description') ?></small></td>
                                    <td>
                                        <span class="badge badge-primary"><?= $cat['product_count'] ?> products</span>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="<?= url('api/categories.php?action=delete&id=' . $cat['id']) ?>" 
                                           class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Delete this category? Items assigned to it will become Uncategorized.');">
                                            Delete
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
