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

const MAX_ATTEMPTS = 5;
const ATTEMPTS_WINDOW_MIN = 15;

$error = null;
$ip = clientIp();
$blocked = recentFailedAttempts($ip, ATTEMPTS_WINDOW_MIN) >= MAX_ATTEMPTS;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkCsrf();

    if ($blocked) {
        $error = 'Trop de tentatives echouees. Reessayez dans ' . ATTEMPTS_WINDOW_MIN . ' minutes.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $admin = findAdmin($username);

        if ($admin && password_verify($password, $admin['password_hash'])) {
            recordLoginAttempt($ip, $username, true);
            clearLoginAttempts($ip);
            session_regenerate_id(true);
            $_SESSION['admin_id'] = (int) $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: index.php');
            exit;
        }

        recordLoginAttempt($ip, $username, false);
        $remaining = max(0, MAX_ATTEMPTS - recentFailedAttempts($ip, ATTEMPTS_WINDOW_MIN));
        $error = 'Identifiants invalides.';
        if ($remaining > 0 && $remaining <= 3) {
            $error .= ' (' . $remaining . ' tentative' . ($remaining > 1 ? 's' : '') . ' restante' . ($remaining > 1 ? 's' : '') . ')';
        }
        $blocked = recentFailedAttempts($ip, ATTEMPTS_WINDOW_MIN) >= MAX_ATTEMPTS;
        if ($blocked) {
            $error = 'Trop de tentatives echouees. Reessayez dans ' . ATTEMPTS_WINDOW_MIN . ' minutes.';
        }
    }
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
            <input id="username" name="username" type="text" required autofocus <?= $blocked ? 'disabled' : '' ?>>

            <label for="password">Mot de passe</label>
            <input id="password" name="password" type="password" required <?= $blocked ? 'disabled' : '' ?>>

            <button type="submit" class="btn" style="width: 100%; padding: 14px;" <?= $blocked ? 'disabled' : '' ?>>Se connecter</button>
        </form>
    </div>
</div>
<?php adminLayoutBottom();
