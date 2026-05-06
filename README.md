# Noel de Sophie — Site vitrine

Site vitrine pour des décorations de Noël artisanales (boules en cristal gravées au laser 3D).
Production : https://noel.lyblics.com/

## Stack

- **PHP 8** — pages publiques + panel admin
- **SQLite** — stockage des produits (`data/products.db`)
- **Python (utilitaire)** — `extract_images.py` pour découper les visuels depuis les PDFs sources

## Structure

```
LyblicsNoel/
├── index.php               # Page publique (collection)
├── product.php             # Fiche produit publique
├── extract_images.py       # Outil d'extraction d'images (one-shot)
├── admin/
│   ├── login.php           # Connexion
│   ├── setup.php           # Création du 1er admin (auto si DB vide)
│   ├── logout.php
│   ├── index.php           # Dashboard liste produits
│   ├── edit.php            # Création / édition d'un produit
│   ├── delete.php
│   └── auth.php            # Helpers session, CSRF, layout admin
├── includes/
│   └── db.php              # PDO SQLite + helpers CRUD + seed initial
├── data/
│   ├── products.db         # Base SQLite (créée au 1er run, gitignorée)
│   └── .htaccess           # Bloque l'accès direct
├── images/
│   ├── cristal_*.png       # Visuels initiaux
│   └── uploads/            # Images ajoutées via le panel admin
└── lili/                   # PDFs sources (hors web)
```

## Déploiement Coolify

Le projet est livré avec un `Dockerfile` (PHP 8.2 + Apache + SQLite). Coolify le détecte automatiquement.

### Étapes

1. Dans Coolify, créer une nouvelle application en mode **Dockerfile** (et non Nixpacks).
2. Pointer vers le dépôt Git.
3. **⚠️ Configurer 2 volumes persistants** dans l'onglet *Storage* (sinon la base et les images uploadées sont perdues à chaque redéploiement) :
   - Mount path : `/var/www/html/data` → pour la base SQLite
   - Mount path : `/var/www/html/images/uploads` → pour les images uploadées par l'admin
4. Déployer. Au premier accès :
   - La base SQLite est créée et seedée avec les 10 produits initiaux.
   - Aller sur `/admin/` pour créer le premier compte administrateur (formulaire de setup affiché automatiquement).

### Permissions

Le `Dockerfile` configure déjà les bons droits (`www-data` peut écrire dans `data/` et `images/uploads/`). Si tu déploies sans Docker, exécute :

```bash
chown -R www-data:www-data data images/uploads
chmod -R 775 data images/uploads
```

## Panel admin

- URL : `/admin/`
- Premier accès : redirige vers `/admin/setup.php` pour créer le compte initial.
- Gestion des produits : création, édition (nom, slug, descriptions, prix, badge, note, image, ordre, visibilité), suppression.
- Upload d'images : JPG / PNG / WEBP, max 5 Mo. Stocké dans `images/uploads/`.

## Extraction des images (utilitaire)

Le script `extract_images.py` découpe les cristaux depuis les PDFs sources de `lili/`.

```bash
pip install pymupdf pillow
python extract_images.py
```

Les chemins sont à adapter en tête du fichier. Sortie dans `images/cristal_XX.jpg` (500×500 px).
