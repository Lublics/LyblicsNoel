<?php
require_once __DIR__ . '/auth.php';

if (adminCount() === 0) {
    header('Location: setup.php');
    exit;
}

if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkCsrf();
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $admin = findAdmin($username);

    if ($admin && password_verify($password, $admin['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int) $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header('Location: index.php');
        exit;
    }

    $error = 'Identifiants invalides.';
}

adminLayoutTop('Connexion');
?>
<div class="login-wrap">
    <div class="card">
        <h1>Connexion</h1>

        <?php if ($error): ?>
            <div class="flash flash-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php renderFlash(); ?>

        <form method="post">
            <input type="hidden" name="csrf" value="<?= csrfToken() ?>">

            <label for="username">Identifiant</label>
            <input id="username" name="username" type="text" required autofocus>

            <label for="password">Mot de passe</label>
            <input id="password" name="password" type="password" required>

            <button type="submit" class="btn" style="width: 100%; padding: 14px;">Se connecter</button>
        </form>
    </div>
</div>
<?php adminLayoutBottom();
