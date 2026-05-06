<?php
require_once __DIR__ . '/../includes/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn(): bool {
    return !empty($_SESSION['admin_id']);
}

function requireAuth(): void {
    if (adminCount() === 0) {
        header('Location: setup.php');
        exit;
    }
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function csrfToken(): string {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function checkCsrf(): void {
    $token = $_POST['csrf'] ?? '';
    if (!hash_equals($_SESSION['csrf'] ?? '', $token)) {
        http_response_code(400);
        exit('Token CSRF invalide.');
    }
}

function flash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function consumeFlash(): ?array {
    if (empty($_SESSION['flash'])) {
        return null;
    }
    $f = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $f;
}

function adminLayoutTop(string $title): void {
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlspecialchars($title) ?> - Admin Noel de Sophie</title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body {
                font-family: system-ui, -apple-system, sans-serif;
                background: #f5f2ee;
                color: #2c3e50;
                line-height: 1.5;
            }
            .admin-header {
                background: #0f4270;
                color: #fff;
                padding: 1rem 2rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .admin-header a {
                color: #fff;
                text-decoration: none;
                margin-left: 1.5rem;
                font-size: 0.95rem;
            }
            .admin-header a:hover { color: #c9a959; }
            .admin-header .brand { font-weight: 700; letter-spacing: 1px; }
            .nav-badge {
                display: inline-block;
                background: #c0392b;
                color: #fff;
                font-size: 0.7rem;
                padding: 2px 7px;
                border-radius: 10px;
                margin-left: 4px;
                font-weight: 700;
            }
            .admin-container {
                max-width: 1100px;
                margin: 2rem auto;
                padding: 0 1.5rem;
            }
            .card {
                background: #fff;
                padding: 2rem;
                box-shadow: 0 2px 10px rgba(0,0,0,0.06);
                margin-bottom: 1.5rem;
            }
            h1, h2, h3 { color: #0f4270; margin-bottom: 1rem; }
            h1 { font-size: 1.8rem; }
            h2 { font-size: 1.4rem; }
            label {
                display: block;
                font-weight: 600;
                margin-bottom: 0.4rem;
                font-size: 0.9rem;
            }
            input[type=text], input[type=password], input[type=email],
            input[type=number], input[type=file], select, textarea {
                width: 100%;
                padding: 10px 12px;
                border: 1px solid #d4d0ca;
                background: #fff;
                font-size: 0.95rem;
                font-family: inherit;
                margin-bottom: 1rem;
            }
            textarea { resize: vertical; min-height: 80px; }
            input:focus, select:focus, textarea:focus {
                outline: none;
                border-color: #0f4270;
            }
            .form-row {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
            }
            .btn {
                display: inline-block;
                background: #0f4270;
                color: #fff;
                padding: 10px 20px;
                border: none;
                cursor: pointer;
                text-decoration: none;
                font-size: 0.9rem;
                letter-spacing: 0.5px;
                transition: background 0.2s;
            }
            .btn:hover { background: #c9a959; }
            .btn-secondary { background: #6c757d; }
            .btn-danger { background: #c0392b; }
            .btn-danger:hover { background: #e74c3c; }
            .btn-sm { padding: 6px 12px; font-size: 0.85rem; }
            table {
                width: 100%;
                border-collapse: collapse;
                background: #fff;
            }
            th, td {
                padding: 0.75rem;
                text-align: left;
                border-bottom: 1px solid #e8e5e0;
                font-size: 0.9rem;
            }
            th {
                background: #f5f2ee;
                font-weight: 600;
                color: #0f4270;
            }
            td img {
                max-width: 60px;
                max-height: 60px;
                object-fit: cover;
            }
            .actions { display: flex; gap: 0.5rem; }
            .badge {
                display: inline-block;
                padding: 3px 8px;
                font-size: 0.75rem;
                background: #c9a959;
                color: #fff;
                border-radius: 3px;
            }
            .status-active { color: #27ae60; font-weight: 600; }
            .status-inactive { color: #c0392b; font-weight: 600; }
            .flash {
                padding: 1rem 1.5rem;
                margin-bottom: 1.5rem;
                border-left: 4px solid;
            }
            .flash-success { background: #d4edda; border-color: #27ae60; color: #155724; }
            .flash-error   { background: #f8d7da; border-color: #c0392b; color: #721c24; }
            .checkbox-row {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                margin-bottom: 1rem;
            }
            .checkbox-row input { width: auto; margin: 0; }
            .checkbox-row label { margin: 0; }
            .login-wrap {
                max-width: 420px;
                margin: 5rem auto;
                padding: 0 1.5rem;
            }
            .help {
                font-size: 0.85rem;
                color: #777;
                margin-top: -0.7rem;
                margin-bottom: 1rem;
            }
        </style>
    </head>
    <body>
    <?php
}

function adminLayoutBottom(): void {
    echo '</body></html>';
}

function adminHeader(): void {
    $unread = unreadMessagesCount();
    ?>
    <header class="admin-header">
        <div class="brand">NOEL DE SOPHIE — ADMIN</div>
        <nav>
            <a href="index.php">Produits</a>
            <a href="edit.php">Nouveau produit</a>
            <a href="messages.php">Messages<?php if ($unread > 0): ?> <span class="nav-badge"><?= $unread ?></span><?php endif; ?></a>
            <a href="../index.php" target="_blank">Voir le site</a>
            <a href="logout.php">Deconnexion</a>
        </nav>
    </header>
    <?php
}

function renderFlash(): void {
    $f = consumeFlash();
    if (!$f) return;
    $cls = $f['type'] === 'success' ? 'flash-success' : 'flash-error';
    echo '<div class="flash ' . $cls . '">' . htmlspecialchars($f['message']) . '</div>';
}
