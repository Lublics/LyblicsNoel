<?php
require_once __DIR__ . '/includes/db.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Methode non autorisee.']);
    exit;
}

if (!empty($_POST['website'])) {
    echo json_encode(['ok' => true]);
    exit;
}

$nom       = trim($_POST['nom'] ?? '');
$prenom    = trim($_POST['prenom'] ?? '');
$email     = trim($_POST['email'] ?? '');
$telephone = trim($_POST['telephone'] ?? '');
$sujet     = trim($_POST['sujet'] ?? '');
$message   = trim($_POST['message'] ?? '');

$errors = [];
if ($nom === '' || mb_strlen($nom) > 100)        $errors[] = 'Nom invalide.';
if ($prenom === '' || mb_strlen($prenom) > 100)  $errors[] = 'Prenom invalide.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL))  $errors[] = 'Email invalide.';
if ($sujet === '')                                $errors[] = 'Sujet manquant.';
if (mb_strlen($message) < 5)                     $errors[] = 'Message trop court.';
if (mb_strlen($message) > 5000)                  $errors[] = 'Message trop long.';
if ($telephone !== '' && mb_strlen($telephone) > 30) $errors[] = 'Telephone invalide.';

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'errors' => $errors]);
    exit;
}

try {
    saveMessage([
        'nom'        => $nom,
        'prenom'     => $prenom,
        'email'      => $email,
        'telephone'  => $telephone,
        'sujet'      => $sujet,
        'message'    => $message,
        'ip'         => clientIp(),
        'user_agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 500),
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Erreur serveur. Reessayez plus tard.']);
    exit;
}

echo json_encode(['ok' => true]);
