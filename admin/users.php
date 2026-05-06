<?php
require_once __DIR__ . '/auth.php';
requireAuth();

const MIN_PWD_LEN = 8;
const MIN_USER_LEN = 3;

$errors = [];
$action = $_POST['action'] ?? null;

if ($action) {
    checkCsrf();

    if ($action === 'create') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm']  ?? '';

        if (mb_strlen($username) < MIN_USER_LEN) {
            $errors[] = 'Identifiant trop court (min. ' . MIN_USER_LEN . ' caracteres).';
        } elseif (adminUsernameExists($username)) {
            $errors[] = 'Cet identifiant est deja utilise.';
        }
        if (strlen($password) < MIN_PWD_LEN) {
            $errors[] = 'Mot de passe trop court (min. ' . MIN_PWD_LEN . ' caracteres).';
        } elseif ($password !== $confirm) {
            $errors[] = 'Les mots de passe ne correspondent pas.';
        }

        if (empty($errors)) {
            createAdmin($username, $password);
            flash('success', 'Compte administrateur "' . htmlspecialchars($username) . '" cree.');
            header('Location: users.php');
            exit;
        }
    }

    if ($action === 'delete') {
        $id = (int) ($_POST['id'] ?? 0);

        if ($id === (int) $_SESSION['admin_id']) {
            flash('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        } elseif ($id <= 0 || !getAdminById($id)) {
            flash('error', 'Compte introuvable.');
        } elseif (!deleteAdmin($id)) {
            flash('error', 'Impossible de supprimer le dernier compte administrateur.');
        } else {
            flash('success', 'Compte supprime.');
        }
        header('Location: users.php');
        exit;
    }

    if ($action === 'reset_password') {
        $id          = (int) ($_POST['id'] ?? 0);
        $newPassword = $_POST['new_password'] ?? '';
        $confirm     = $_POST['confirm']      ?? '';
        $current     = $_POST['current_password'] ?? '';

        $isOwn = $id === (int) $_SESSION['admin_id'];

        if ($id <= 0 || !getAdminById($id)) {
            $errors[] = 'Compte introuvable.';
        }
        if (strlen($newPassword) < MIN_PWD_LEN) {
            $errors[] = 'Nouveau mot de passe trop court (min. ' . MIN_PWD_LEN . ' caracteres).';
        } elseif ($newPassword !== $confirm) {
            $errors[] = 'Les mots de passe ne correspondent pas.';
        }
        if ($isOwn && !verifyAdminPassword($id, $current)) {
            $errors[] = 'Le mot de passe actuel est incorrect.';
        }

        if (empty($errors)) {
            updateAdminPassword($id, $newPassword);
            flash('success', 'Mot de passe mis a jour.');
            header('Location: users.php');
            exit;
        }
    }
}

$admins = getAdmins();
$currentId = (int) $_SESSION['admin_id'];

adminLayoutTop('Comptes administrateurs');
adminHeader();
?>
<div class="admin-container">
    <?php renderFlash(); ?>

    <h1>Comptes administrateurs (<?= count($admins) ?>)</h1>
    <p style="color: #666; margin-bottom: 1.5rem;">
        Seuls les administrateurs connectes peuvent creer ou supprimer des comptes ici.
    </p>

    <?php if (!empty($errors)): ?>
        <div class="flash flash-error">
            <strong>Erreurs :</strong>
            <ul style="margin-top: 0.5rem; margin-left: 1.5rem;">
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card">
        <h2>Creer un nouveau compte</h2>
        <form method="post">
            <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
            <input type="hidden" name="action" value="create">

            <div class="form-row">
                <div>
                    <label for="username">Identifiant</label>
                    <input id="username" name="username" type="text" required minlength="<?= MIN_USER_LEN ?>" autocomplete="off">
                </div>
                <div></div>
            </div>

            <div class="form-row">
                <div>
                    <label for="password">Mot de passe</label>
                    <input id="password" name="password" type="password" required minlength="<?= MIN_PWD_LEN ?>" autocomplete="new-password">
                    <p class="help">Minimum <?= MIN_PWD_LEN ?> caracteres.</p>
                </div>
                <div>
                    <label for="confirm">Confirmer</label>
                    <input id="confirm" name="confirm" type="password" required minlength="<?= MIN_PWD_LEN ?>" autocomplete="new-password">
                </div>
            </div>

            <button type="submit" class="btn">Creer le compte</button>
        </form>
    </div>

    <div class="card" style="padding: 0; overflow: hidden;">
        <table>
            <thead>
                <tr>
                    <th>Identifiant</th>
                    <th>Cree le</th>
                    <th style="width: 380px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($admins as $a):
                    $isMe = (int) $a['id'] === $currentId;
                    $isLast = count($admins) === 1;
                ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($a['username']) ?></strong>
                            <?php if ($isMe): ?>
                                <span style="font-size: 0.75rem; color: #c9a959; margin-left: 6px;">(vous)</span>
                            <?php endif; ?>
                        </td>
                        <td style="font-size: 0.85rem; color: #666;"><?= htmlspecialchars($a['created_at']) ?></td>
                        <td>
                            <details>
                                <summary style="cursor: pointer; color: #0f4270; font-size: 0.85rem; display: inline-block; margin-right: 8px;">Changer le mot de passe</summary>
                                <form method="post" style="margin-top: 0.5rem; padding: 1rem; background: #f5f2ee; border-left: 3px solid #c9a959;">
                                    <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
                                    <input type="hidden" name="action" value="reset_password">
                                    <input type="hidden" name="id" value="<?= (int) $a['id'] ?>">

                                    <?php if ($isMe): ?>
                                        <label>Mot de passe actuel</label>
                                        <input name="current_password" type="password" required autocomplete="current-password">
                                    <?php endif; ?>

                                    <label>Nouveau mot de passe</label>
                                    <input name="new_password" type="password" required minlength="<?= MIN_PWD_LEN ?>" autocomplete="new-password">

                                    <label>Confirmer</label>
                                    <input name="confirm" type="password" required minlength="<?= MIN_PWD_LEN ?>" autocomplete="new-password">

                                    <button type="submit" class="btn btn-sm">Mettre a jour</button>
                                </form>
                            </details>

                            <?php if (!$isMe && !$isLast): ?>
                                <form method="post" onsubmit="return confirm('Supprimer definitivement ce compte ?');" style="display: inline;">
                                    <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= (int) $a['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php adminLayoutBottom();
