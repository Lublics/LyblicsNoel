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

## Installation

Sur le VPS (déploiement Coolify ou tout hébergement PHP 8+) :

1. Cloner le dépôt à la racine web.
2. S'assurer que PHP a le droit d'écrire dans `data/` et `images/uploads/`.
3. Ouvrir le site dans un navigateur — la base SQLite et le seed des 10 produits initiaux sont créés automatiquement au premier accès.
4. Ouvrir `/admin/` : un formulaire de configuration apparaît pour créer le premier compte administrateur.
5. Se connecter et gérer les produits.

### Permissions

```bash
chmod -R 775 data images/uploads
```

(adapter selon l'utilisateur du process PHP-FPM)

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
