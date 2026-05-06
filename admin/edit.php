<?php
require_once __DIR__ . '/auth.php';
requireAuth();

$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
$product = $id ? getProductById($id) : null;
$isNew = $product === null;

if ($id && !$product) {
    flash('error', 'Produit introuvable.');
    header('Location: index.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkCsrf();

    $data = [
        'slug'               => slugify(trim($_POST['slug'] ?? '')),
        'name'               => trim($_POST['name'] ?? ''),
        'description_courte' => trim($_POST['description_courte'] ?? ''),
        'description_longue' => trim($_POST['description_longue'] ?? ''),
        'prix'               => (float) ($_POST['prix'] ?? 0),
        'badge'              => trim($_POST['badge'] ?? ''),
        'rating'             => max(0, min(5, (int) ($_POST['rating'] ?? 5))),
        'dimensions'         => trim($_POST['dimensions'] ?? ''),
        'materiau'           => trim($_POST['materiau'] ?? ''),
        'inclus'             => trim($_POST['inclus'] ?? ''),
        'actif'              => isset($_POST['actif']) ? 1 : 0,
        'ordre'              => (int) ($_POST['ordre'] ?? 0),
        'image'              => $product['image'] ?? '',
    ];

    if ($data['name'] === '') {
        $errors[] = 'Le nom est obligatoire.';
    }
    if ($data['slug'] === '') {
        $errors[] = 'Le slug est obligatoire.';
    }

    if (!empty($_FILES['image']['name'])) {
        $upload = handleImageUpload($_FILES['image']);
        if ($upload['error']) {
            $errors[] = $upload['error'];
        } else {
            $data['image'] = $upload['path'];
        }
    }

    if (empty($errors)) {
        try {
            $newId = saveProduct($data, $id);
            flash('success', $isNew ? 'Produit cree.' : 'Produit mis a jour.');
            header('Location: edit.php?id=' . $newId);
            exit;
        } catch (PDOException $e) {
            if (str_contains($e->getMessage(), 'UNIQUE constraint failed')) {
                $errors[] = 'Ce slug est deja utilise par un autre produit.';
            } else {
                $errors[] = 'Erreur base de donnees: ' . $e->getMessage();
            }
        }
    }

    $product = array_merge($product ?? [], $data);
    $product['id'] = $id;
}

function slugify(string $s): string {
    $s = strtolower($s);
    $s = preg_replace('/[^a-z0-9]+/', '-', $s);
    return trim($s, '-');
}

function handleImageUpload(array $file): array {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['error' => 'Erreur upload (code ' . $file['error'] . ').', 'path' => null];
    }

    $maxSize = 5 * 1024 * 1024;
    if ($file['size'] > $maxSize) {
        return ['error' => 'Image trop volumineuse (max 5 Mo).', 'path' => null];
    }

    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    if (!isset($allowed[$mime])) {
        return ['error' => 'Format non supporte (JPG, PNG, WEBP uniquement).', 'path' => null];
    }
    $ext = $allowed[$mime];

    $dir = __DIR__ . '/../images/uploads';
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }

    $name = 'cristal_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $dest = $dir . '/' . $name;

    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        return ['error' => 'Echec de l\'enregistrement du fichier.', 'path' => null];
    }

    return ['error' => null, 'path' => 'images/uploads/' . $name];
}

adminLayoutTop($isNew ? 'Nouveau produit' : 'Editer ' . $product['name']);
adminHeader();
?>
<div class="admin-container">
    <a href="index.php" style="color: #0f4270; text-decoration: none; font-size: 0.9rem;">&larr; Retour aux produits</a>

    <h1 style="margin-top: 1rem;"><?= $isNew ? 'Nouveau produit' : 'Editer : ' . htmlspecialchars($product['name']) ?></h1>

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

    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf" value="<?= csrfToken() ?>">

        <div class="card">
            <h2>Informations principales</h2>

            <div class="form-row">
                <div>
                    <label for="name">Nom du produit *</label>
                    <input id="name" name="name" type="text" required value="<?= htmlspecialchars($product['name'] ?? '') ?>">
                </div>
                <div>
                    <label for="slug">Slug (URL) *</label>
                    <input id="slug" name="slug" type="text" required value="<?= htmlspecialchars($product['slug'] ?? '') ?>" placeholder="cristal-XX">
                    <p class="help">Identifiant URL (lettres/chiffres/tirets). Ex: cristal-01</p>
                </div>
            </div>

            <label for="description_courte">Description courte</label>
            <textarea id="description_courte" name="description_courte" rows="2"><?= htmlspecialchars($product['description_courte'] ?? '') ?></textarea>
            <p class="help">Affichee sur la carte de la collection.</p>

            <label for="description_longue">Description longue</label>
            <textarea id="description_longue" name="description_longue" rows="6"><?= htmlspecialchars($product['description_longue'] ?? '') ?></textarea>
            <p class="help">Affichee sur la fiche produit complete.</p>
        </div>

        <div class="card">
            <h2>Image</h2>
            <?php if (!empty($product['image'])): ?>
                <div style="margin-bottom: 1rem;">
                    <img src="../<?= htmlspecialchars($product['image']) ?>" alt="" style="max-width: 200px; border: 1px solid #d4d0ca;">
                    <p class="help" style="margin-top: 0.5rem;">Image actuelle. Choisissez un nouveau fichier pour la remplacer.</p>
                </div>
            <?php endif; ?>
            <label for="image">Fichier image (JPG, PNG, WEBP — max 5 Mo)</label>
            <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp">
        </div>

        <div class="card">
            <h2>Prix et affichage</h2>

            <div class="form-row">
                <div>
                    <label for="prix">Prix (EUR) *</label>
                    <input id="prix" name="prix" type="number" step="0.01" min="0" required value="<?= htmlspecialchars((string) ($product['prix'] ?? 0)) ?>">
                </div>
                <div>
                    <label for="badge">Badge (optionnel)</label>
                    <input id="badge" name="badge" type="text" value="<?= htmlspecialchars($product['badge'] ?? '') ?>" placeholder="NOUVEAUTE, BEST-SELLER...">
                </div>
            </div>

            <div class="form-row">
                <div>
                    <label for="rating">Note (0 a 5)</label>
                    <input id="rating" name="rating" type="number" min="0" max="5" value="<?= htmlspecialchars((string) ($product['rating'] ?? 5)) ?>">
                </div>
                <div>
                    <label for="ordre">Ordre d'affichage</label>
                    <input id="ordre" name="ordre" type="number" value="<?= htmlspecialchars((string) ($product['ordre'] ?? 0)) ?>">
                    <p class="help">Plus petit = affiche en premier.</p>
                </div>
            </div>

            <div class="checkbox-row">
                <input type="checkbox" id="actif" name="actif" <?= ((int) ($product['actif'] ?? 1) === 1) ? 'checked' : '' ?>>
                <label for="actif">Visible sur le site public</label>
            </div>
        </div>

        <div class="card">
            <h2>Caracteristiques</h2>

            <label for="dimensions">Dimensions</label>
            <input id="dimensions" name="dimensions" type="text" value="<?= htmlspecialchars($product['dimensions'] ?? '') ?>" placeholder="Diametre: 8cm">

            <label for="materiau">Materiau</label>
            <input id="materiau" name="materiau" type="text" value="<?= htmlspecialchars($product['materiau'] ?? '') ?>" placeholder="Cristal K9 haute qualite">

            <label for="inclus">Contenu de la livraison</label>
            <input id="inclus" name="inclus" type="text" value="<?= htmlspecialchars($product['inclus'] ?? '') ?>" placeholder="Boule cristal + Socle bois LED + Cable USB">
        </div>

        <div style="display: flex; gap: 1rem; margin-bottom: 3rem;">
            <button type="submit" class="btn"><?= $isNew ? 'Creer le produit' : 'Enregistrer les modifications' ?></button>
            <a href="index.php" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

<script>
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    let slugTouched = <?= $isNew ? 'false' : 'true' ?>;
    slugInput.addEventListener('input', () => slugTouched = true);
    nameInput.addEventListener('input', () => {
        if (slugTouched) return;
        slugInput.value = nameInput.value
            .toLowerCase()
            .normalize('NFD').replace(/[̀-ͯ]/g, '')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
    });
</script>
<?php adminLayoutBottom();
