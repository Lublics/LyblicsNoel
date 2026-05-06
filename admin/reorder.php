<?php
require_once __DIR__ . '/auth.php';
requireAuth();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Methode non autorisee.']);
    exit;
}

checkCsrf();

$ids = $_POST['ids'] ?? null;

if (!is_array($ids) || empty($ids)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'Liste d\'IDs invalide.']);
    exit;
}

try {
    reorderProducts(array_map('intval', $ids));
    echo json_encode(['ok' => true]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
