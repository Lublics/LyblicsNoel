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

    <div id="reorderStatus" style="display: none; padding: 0.5rem 1rem; margin-bottom: 0.5rem; font-size: 0.85rem;"></div>

    <div class="card" style="padding: 0; overflow: hidden;">
        <table id="productsTable">
            <thead>
                <tr>
                    <th style="width: 30px;"></th>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Slug</th>
                    <th>Prix</th>
                    <th>Badge</th>
                    <th>Statut</th>
                    <th style="width: 200px;">Actions</th>
                </tr>
            </thead>
            <tbody id="sortableProducts">
                <?php if (empty($products)): ?>
                    <tr><td colspan="8" style="text-align: center; padding: 2rem; color: #888;">Aucun produit</td></tr>
                <?php endif; ?>

                <?php foreach ($products as $p): ?>
                    <tr data-id="<?= (int) $p['id'] ?>">
                        <td class="drag-handle" style="cursor: grab; color: #999; text-align: center; user-select: none;" title="Glisser pour reordonner">⋮⋮</td>
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

<style>
    #sortableProducts tr.dragging { opacity: 0.5; }
    #sortableProducts tr.drag-over { border-top: 2px solid #c9a959; }
    .drag-handle:active { cursor: grabbing; }
    #reorderStatus.success { background: #d4edda; color: #155724; }
    #reorderStatus.error { background: #f8d7da; color: #721c24; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
    const tbody = document.getElementById('sortableProducts');
    const status = document.getElementById('reorderStatus');
    const csrfTok = <?= json_encode(csrfToken()) ?>;

    function showStatus(message, type) {
        status.textContent = message;
        status.className = type;
        status.style.display = 'block';
        if (type === 'success') {
            setTimeout(() => { status.style.display = 'none'; }, 2000);
        }
    }

    if (tbody && tbody.children.length > 0 && tbody.children[0].dataset.id) {
        Sortable.create(tbody, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'dragging',
            onEnd: async () => {
                const ids = [...tbody.querySelectorAll('tr[data-id]')].map(tr => tr.dataset.id);
                const fd = new FormData();
                fd.append('csrf', csrfTok);
                ids.forEach(id => fd.append('ids[]', id));

                try {
                    const res = await fetch('reorder.php', { method: 'POST', body: fd });
                    const data = await res.json();
                    if (res.ok && data.ok) {
                        showStatus('Ordre enregistre.', 'success');
                    } else {
                        showStatus('Erreur : ' + (data.error || 'inconnue'), 'error');
                    }
                } catch (err) {
                    showStatus('Erreur reseau.', 'error');
                }
            }
        });
    }
</script>
<?php adminLayoutBottom();
