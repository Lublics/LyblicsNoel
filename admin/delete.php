<?php
require_once __DIR__ . '/auth.php';
requireAuth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

checkCsrf();

$id = (int) ($_POST['id'] ?? 0);
if ($id > 0) {
    deleteProduct($id);
    flash('success', 'Produit supprime.');
} else {
    flash('error', 'ID invalide.');
}

header('Location: index.php');
exit;
