# Architecture — LyblicsNoel

> Calendrier de l'Avent interactif — PHP + assets

## Stack

- **PHP** (pages dynamiques)
- **Python** (script utilitaire)
- Assets statiques (images PNG/JPG, PDFs)

## Structure

```
LyblicsNoel/
├── index.php               # Page principale (calendrier de l'Avent)
├── product.php             # Page produit/case de l'Avent
├── extract_images.py       # Script Python : extraction d'images depuis PDFs
├── images/
│   └── cristal_*.jpg/png   # Images des cases (cristaux)
├── lili/
│   ├── Page - XX.pdf       # Pages PDF source (1 à 40)
│   ├── commande.xlsx        # Fichier de commande
│   └── commandepdf.pdf     # Commandes en PDF
└── 1.png … 10.png          # Miniatures des cases
```

## Description

Calendrier de l'Avent avec cases cliquables. Les images `cristal_*.png` sont extraites depuis les PDFs via `extract_images.py`. Chaque case renvoie vers une page `product.php`.
