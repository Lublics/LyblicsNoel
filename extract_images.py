import fitz  # PyMuPDF
from PIL import Image
import os

# Configuration
pdf_path = r"C:\Users\renau\Desktop\DEV SITE\sitenoel\lili\Page - 01.pdf"
output_dir = r"C:\Users\renau\Desktop\DEV SITE\sitenoel\images"

# Images a extraire (numeros du PDF)
images_to_extract = [1, 3, 7, 12, 14, 15, 17, 19, 23, 24]

# Grille 4 colonnes x 6 lignes
cols = 4
rows = 6

# Ouvrir le PDF
doc = fitz.open(pdf_path)
page = doc[0]

# Obtenir les dimensions de la page
page_rect = page.rect
page_width = page_rect.width
page_height = page_rect.height

# Augmenter la resolution pour de meilleures images
zoom = 4  # facteur de zoom augmente
mat = fitz.Matrix(zoom, zoom)

# Rendre la page entiere en haute resolution
pix = page.get_pixmap(matrix=mat)
img = Image.frombytes("RGB", [pix.width, pix.height], pix.samples)

# Dimensions de la page en pixels
pw = pix.width
ph = pix.height

# Marges ajustees pour la grille (en pourcentage de la page)
top_margin_pct = 0.035      # espace pour "01" en haut
bottom_margin_pct = 0.01
left_margin_pct = 0.02
right_margin_pct = 0.02

# Zone de contenu
content_left = int(pw * left_margin_pct)
content_top = int(ph * top_margin_pct)
content_right = int(pw * (1 - right_margin_pct))
content_bottom = int(ph * (1 - bottom_margin_pct))

content_width = content_right - content_left
content_height = content_bottom - content_top

# Taille de chaque cellule
cell_width = content_width / cols
cell_height = content_height / rows

# Marge interne pour cadrer uniquement sur la boule (en % de la cellule)
number_margin_pct = 0.17  # 17% en bas - enlever numero
top_cell_margin_pct = 0.05  # 5% en haut
side_margin_pct = 0.08  # 8% sur les cotes

# Extraire chaque image
for num in images_to_extract:
    # Calculer la position dans la grille (0-indexed)
    idx = num - 1
    row = idx // cols
    col = idx % cols

    # Calculer les coordonnees de la cellule
    cell_x1 = content_left + col * cell_width
    cell_y1 = content_top + row * cell_height
    cell_x2 = cell_x1 + cell_width
    cell_y2 = cell_y1 + cell_height

    # Appliquer les marges internes pour ne garder que l'image
    x1 = int(cell_x1 + cell_width * side_margin_pct)
    y1 = int(cell_y1 + cell_height * top_cell_margin_pct)
    x2 = int(cell_x2 - cell_width * side_margin_pct)
    y2 = int(cell_y2 - cell_height * number_margin_pct)

    # Rogner l'image
    cropped = img.crop((x1, y1, x2, y2))

    # Redimensionner pour le web (500x500 pour meilleure qualite)
    cropped = cropped.resize((500, 500), Image.Resampling.LANCZOS)

    # Sauvegarder
    output_path = os.path.join(output_dir, f"cristal_{num:02d}.jpg")
    cropped.save(output_path, "JPEG", quality=92)
    print(f"Extrait: cristal_{num:02d}.jpg ({x2-x1}x{y2-y1}px -> 500x500)")

doc.close()
print(f"\nTermine! {len(images_to_extract)} images extraites dans {output_dir}")
