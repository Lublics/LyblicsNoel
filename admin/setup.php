<?php
require_once __DIR__ . '/auth.php';

if (adminCount() > 0) {
    header('Location: login.php');
    exit;
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkCsrf();
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm'] ?? '';

    if (strlen($username) < 3) {
        $error = 'Identifiant trop court (min. 3 caracteres).';
    } elseif (strlen($password) < 8) {
        $error = 'Mot de passe trop court (min. 8 caracteres).';
    } elseif ($password !== $confirm) {
        $error = 'Les mots de passe ne correspondent pas.';
    } else {
        createAdmin($username, $password);
        flash('success', 'Compte administrateur cree. Connectez-vous.');
        header('Location: login.php');
        exit;
    }
}

adminLayoutTop('Configuration initiale');
?>
<div class="login-wrap">
    <div class="card">
        <h1>Premiere configuration</h1>
        <p style="color: #666; margin-bottom: 1.5rem; font-size: 0.95rem;">
            Aucun administrateur n'existe encore. Creez le premier compte pour acceder au panel.
        </p>

        <?php if ($error): ?>
            <div class="flash flash-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="csrf" value="<?= csrfToken() ?>">

            <label for="username">Identifiant</label>
            <input id="username" name="username" type="text" required minlength="3" autofocus>

            <label for="password">Mot de passe</label>
            <input id="password" name="password" type="password" required minlength="8">
            <p class="help">Minimum 8 caracteres.</p>

            <label for="confirm">Confirmer le mot de passe</label>
            <input id="confirm" name="confirm" type="password" required minlength="8">

            <button type="submit" class="btn" style="width: 100%; padding: 14px;">Creer le compte</button>
        </form>
    </div>
</div>
<?php adminLayoutBottom();
