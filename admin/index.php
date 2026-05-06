<?php
require_once __DIR__ . '/auth.php';
requireAuth();

$products = getProducts(false);

adminLayoutTop('Produits');
adminHeader();
?>
<div class="admin-container">
    <?php renderFlash(); ?>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h1>Produits (<?= count($products) ?>)</h1>
        <a href="edit.php" class="btn">+ Nouveau produit</a>
    </div>

    <div class="card" style="padding: 0; overflow: hidden;">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Slug</th>
                    <th>Prix</th>
                    <th>Badge</th>
                    <th>Statut</th>
                    <th style="width: 200px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr><td colspan="7" style="text-align: center; padding: 2rem; color: #888;">Aucun produit</td></tr>
                <?php endif; ?>

                <?php foreach ($products as $p): ?>
                    <tr>
                        <td>
                            <?php if (!empty($p['image'])): ?>
                                <img src="../<?= htmlspecialchars($p['image']) ?>" alt="">
                            <?php endif; ?>
                        </td>
                        <td><strong><?= htmlspecialchars($p['name']) ?></strong></td>
                        <td><code><?= htmlspecialchars($p['slug']) ?></code></td>
                        <td><?= number_format((float) $p['prix'], 2, ',', ' ') ?> EUR</td>
                        <td>
                            <?php if (!empty($p['badge'])): ?>
                                <span class="badge"><?= htmlspecialchars($p['badge']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ((int) $p['actif'] === 1): ?>
                                <span class="status-active">Visible</span>
                            <?php else: ?>
                                <span class="status-inactive">Cache</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="edit.php?id=<?= (int) $p['id'] ?>" class="btn btn-sm">Editer</a>
                                <form method="post" action="delete.php" onsubmit="return confirm('Supprimer definitivement ce produit ?');" style="display: inline;">
                                    <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
                                    <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php adminLayoutBottom();
