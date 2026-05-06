<?php
require_once __DIR__ . '/auth.php';
requireAuth();

$groups = [
    'General' => [
        'site_title'   => ['Titre de la page (onglet navigateur)', 'text'],
        'logo_text'    => ['Texte du logo en en-tete', 'text'],
        'announcement' => ['Bandeau d\'annonce (HTML autorise)', 'text'],
    ],
    'Hero' => [
        'hero_title'    => ['Titre principal', 'text'],
        'hero_subtitle' => ['Sous-titre', 'textarea'],
        'hero_cta'      => ['Bouton d\'appel a l\'action', 'text'],
    ],
    'Collection' => [
        'collection_title'       => ['Titre de section', 'text'],
        'collection_subtitle'    => ['Sous-titre de section', 'text'],
        'collection_description' => ['Description longue', 'textarea'],
    ],
    'Contact' => [
        'contact_title'    => ['Titre de section', 'text'],
        'contact_subtitle' => ['Sous-titre de section', 'text'],
        'contact_intro'    => ['Intro coordonnees', 'textarea'],
        'contact_phone'    => ['Telephone', 'text'],
        'contact_email'    => ['Email', 'email'],
        'contact_address'  => ['Adresse (sauts de ligne autorises)', 'textarea'],
        'contact_hours'    => ['Horaires (sauts de ligne autorises)', 'textarea'],
    ],
    'Pied de page' => [
        'footer_about'     => ['Texte "A propos"', 'textarea'],
        'footer_copyright' => ['Mention copyright (sans la date)', 'text'],
    ],
];

$allKeys = [];
foreach ($groups as $g) {
    foreach ($g as $k => $_) {
        $allKeys[] = $k;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkCsrf();
    $kv = [];
    foreach ($allKeys as $k) {
        if (array_key_exists($k, $_POST)) {
            $kv[$k] = trim((string) $_POST[$k]);
        }
    }
    saveSettings($kv);
    flash('success', 'Parametres enregistres.');
    header('Location: settings.php');
    exit;
}

$settings = getSettings();

adminLayoutTop('Parametres du site');
adminHeader();
?>
<div class="admin-container">
    <?php renderFlash(); ?>
    <h1>Parametres du site</h1>
    <p style="color: #666; margin-bottom: 1.5rem;">Modifiez ici les textes affiches sur le site public.</p>

    <form method="post">
        <input type="hidden" name="csrf" value="<?= csrfToken() ?>">

        <?php foreach ($groups as $groupName => $fields): ?>
            <div class="card">
                <h2><?= htmlspecialchars($groupName) ?></h2>
                <?php foreach ($fields as $key => [$label, $type]): ?>
                    <label for="<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($label) ?></label>
                    <?php $value = $settings[$key] ?? ''; ?>
                    <?php if ($type === 'textarea'): ?>
                        <textarea id="<?= htmlspecialchars($key) ?>" name="<?= htmlspecialchars($key) ?>" rows="4"><?= htmlspecialchars($value) ?></textarea>
                    <?php else: ?>
                        <input id="<?= htmlspecialchars($key) ?>" name="<?= htmlspecialchars($key) ?>" type="<?= htmlspecialchars($type) ?>" value="<?= htmlspecialchars($value) ?>">
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

        <div style="display: flex; gap: 1rem; margin-bottom: 3rem;">
            <button type="submit" class="btn">Enregistrer les modifications</button>
            <a href="../index.php" target="_blank" class="btn btn-secondary">Voir le site</a>
        </div>
    </form>
</div>
<?php adminLayoutBottom();
