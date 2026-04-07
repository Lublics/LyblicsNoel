# Lyblics Noel — Calendrier de l'Avent

Calendrier de l'Avent interactif avec cases cliquables, chaque case révélant un produit (cristal).

## Apercu

- Cases numérotées cliquables sur la page principale
- Chaque case renvoie vers une page produit dédiée
- Images des cristaux extraites automatiquement depuis des PDFs sources

## Stack

- **PHP** — pages dynamiques (`index.php`, `product.php`)
- **Python** — script utilitaire d'extraction d'images (`extract_images.py`)
- **Assets** — images PNG/JPG, PDFs sources

## Structure

```
LyblicsNoel/
├── index.php               # Calendrier de l'Avent (page principale)
├── product.php             # Page produit d'une case
├── extract_images.py       # Extraction d'images depuis les PDFs
├── images/
│   └── cristal_*.jpg/png   # Images des cases (cristaux)
├── lili/
│   ├── Page - XX.pdf       # Pages PDF sources (1 à 40)
│   ├── commande.xlsx        # Fichier de commande
│   └── commandepdf.pdf     # Commandes en PDF
└── 1.png … 10.png          # Miniatures des cases
```

## Extraction des images

Le script `extract_images.py` découpe automatiquement les cristaux depuis les PDFs sources.

### Prérequis

```bash
pip install pymupdf pillow
```

### Utilisation

Mettre à jour les chemins dans `extract_images.py` puis lancer :

```bash
python extract_images.py
```

Les images sont exportées dans `images/` au format `cristal_XX.jpg` (500×500 px).
