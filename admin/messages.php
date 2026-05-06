<?php
require_once __DIR__ . '/auth.php';
requireAuth();

$action = $_POST['action'] ?? null;

if ($action) {
    checkCsrf();
    $id = (int) ($_POST['id'] ?? 0);

    if ($id > 0) {
        if ($action === 'mark_read')   markMessageRead($id, true);
        if ($action === 'mark_unread') markMessageRead($id, false);
        if ($action === 'delete') {
            deleteMessage($id);
            flash('success', 'Message supprime.');
        }
    }

    header('Location: messages.php' . ($action !== 'delete' && isset($_POST['return_to_view']) ? '?id=' . $id : ''));
    exit;
}

$viewId = isset($_GET['id']) ? (int) $_GET['id'] : null;
$viewing = $viewId ? getMessage($viewId) : null;

if ($viewing && (int) $viewing['lu'] === 0) {
    markMessageRead($viewId, true);
    $viewing['lu'] = 1;
}

$messages = getMessages();

adminLayoutTop('Messages');
adminHeader();
?>
<div class="admin-container">
    <?php renderFlash(); ?>

    <h1>Messages recus (<?= count($messages) ?>)</h1>

    <?php if ($viewing): ?>
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: start; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <h2 style="margin-bottom: 0.3rem;"><?= htmlspecialchars($viewing['sujet']) ?></h2>
                    <div style="color: #666; font-size: 0.9rem;">
                        De <strong><?= htmlspecialchars($viewing['prenom'] . ' ' . $viewing['nom']) ?></strong>
                        — <a href="mailto:<?= htmlspecialchars($viewing['email']) ?>"><?= htmlspecialchars($viewing['email']) ?></a>
                        <?php if (!empty($viewing['telephone'])): ?>
                            — <?= htmlspecialchars($viewing['telephone']) ?>
                        <?php endif; ?>
                    </div>
                    <div style="color: #888; font-size: 0.85rem; margin-top: 0.3rem;">
                        Recu le <?= htmlspecialchars($viewing['created_at']) ?> (IP: <?= htmlspecialchars($viewing['ip'] ?? '?') ?>)
                    </div>
                </div>
                <div class="actions">
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
                        <input type="hidden" name="id" value="<?= (int) $viewing['id'] ?>">
                        <input type="hidden" name="action" value="mark_unread">
                        <input type="hidden" name="return_to_view" value="1">
                        <button type="submit" class="btn btn-sm btn-secondary">Marquer non lu</button>
                    </form>
                    <form method="post" style="display: inline;" onsubmit="return confirm('Supprimer ce message ?');">
                        <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
                        <input type="hidden" name="id" value="<?= (int) $viewing['id'] ?>">
                        <input type="hidden" name="action" value="delete">
                        <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
            <div style="white-space: pre-wrap; padding: 1rem; background: #f5f2ee; border-left: 3px solid #c9a959; line-height: 1.6;"><?= htmlspecialchars($viewing['message']) ?></div>
        </div>
    <?php endif; ?>

    <div class="card" style="padding: 0; overflow: hidden;">
        <table>
            <thead>
                <tr>
                    <th style="width: 30px;"></th>
                    <th>De</th>
                    <th>Email</th>
                    <th>Sujet</th>
                    <th>Date</th>
                    <th style="width: 220px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($messages)): ?>
                    <tr><td colspan="6" style="text-align: center; padding: 2rem; color: #888;">Aucun message recu</td></tr>
                <?php endif; ?>

                <?php foreach ($messages as $m): ?>
                    <tr style="<?= (int) $m['lu'] === 0 ? 'font-weight: 600; background: #fff8e7;' : '' ?>">
                        <td><?= (int) $m['lu'] === 0 ? '<span style="color:#c9a959;">●</span>' : '' ?></td>
                        <td><?= htmlspecialchars($m['prenom'] . ' ' . $m['nom']) ?></td>
                        <td><?= htmlspecialchars($m['email']) ?></td>
                        <td><?= htmlspecialchars($m['sujet']) ?></td>
                        <td style="font-size: 0.85rem; color: #666;"><?= htmlspecialchars($m['created_at']) ?></td>
                        <td>
                            <div class="actions">
                                <a href="messages.php?id=<?= (int) $m['id'] ?>" class="btn btn-sm">Voir</a>
                                <form method="post" onsubmit="return confirm('Supprimer ce message ?');" style="display: inline;">
                                    <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
                                    <input type="hidden" name="id" value="<?= (int) $m['id'] ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" class="btn btn-sm btn-danger">Suppr.</button>
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
