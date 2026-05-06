<?php
require_once __DIR__ . '/includes/db.php';

$slug = $_GET['id'] ?? '';
$product = getProduct($slug);

if (!$product || (int) $product['actif'] !== 1) {
    header('Location: index.php');
    exit;
}

function stars(int $rating): string {
    $out = '';
    for ($i = 1; $i <= 5; $i++) {
        $out .= $i <= $rating ? '&#9733;' : '&#9734;';
    }
    return $out;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?> - Noel de Sophie</title>
    <link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&family=Lato:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --primary-blue: #0f4270;
            --cream: #f5f2ee;
            --gold: #c9a959;
            --dark-text: #2c3e50;
            --light-gray: #e8e5e0;
            --white: #ffffff;
        }

        body {
            font-family: 'Lato', sans-serif;
            line-height: 1.6;
            color: var(--dark-text);
            background-color: var(--cream);
        }

        h1, h2, h3, h4 {
            font-family: 'Tenor Sans', serif;
            font-weight: normal;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            background: var(--white);
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-family: 'Tenor Sans', serif;
            font-size: 1.8rem;
            text-decoration: none;
            color: var(--primary-blue);
            letter-spacing: 2px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 400;
            transition: color 0.3s ease;
        }

        .back-btn:hover { color: var(--gold); }

        .product-detail { padding: 4rem 0; }

        .product-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: start;
        }

        .product-image-container { position: relative; }

        .product-main-image {
            width: 100%;
            background: var(--white);
            padding: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        .product-main-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        .product-badge-detail {
            position: absolute;
            top: 30px;
            left: 30px;
            background: var(--gold);
            color: var(--white);
            padding: 8px 16px;
            font-size: 0.85rem;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .product-info-detail { padding: 20px 0; }

        .product-info-detail h1 {
            font-size: 2.5rem;
            color: var(--primary-blue);
            margin-bottom: 1rem;
            letter-spacing: 1px;
        }

        .product-rating-detail {
            color: var(--gold);
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .product-price-detail {
            font-size: 2rem;
            font-weight: 600;
            color: var(--primary-blue);
            margin-bottom: 1.5rem;
        }

        .product-description {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        .product-specs {
            background: var(--white);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .product-specs h3 {
            color: var(--primary-blue);
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }

        .spec-item {
            display: flex;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--light-gray);
        }

        .spec-item:last-child { border-bottom: none; }

        .spec-label {
            font-weight: 600;
            width: 150px;
            color: var(--dark-text);
        }

        .spec-value { color: #666; }

        .contact-cta {
            display: inline-block;
            background: var(--primary-blue);
            color: var(--white);
            padding: 15px 40px;
            font-size: 1rem;
            letter-spacing: 1px;
            text-decoration: none;
            transition: background 0.3s ease;
            margin-bottom: 2rem;
        }

        .contact-cta:hover { background: var(--gold); }

        .product-features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-top: 2rem;
        }

        .feature-item {
            text-align: center;
            padding: 1rem;
            background: var(--white);
        }

        .feature-icon {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .feature-text {
            font-size: 0.85rem;
            color: #666;
        }

        footer {
            background: var(--primary-blue);
            color: var(--white);
            padding: 2rem 0;
            margin-top: 4rem;
        }

        .footer-content {
            text-align: center;
            color: rgba(255,255,255,0.7);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            .product-info-detail h1 { font-size: 1.8rem; }
            .product-features { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <a href="index.php" class="logo">NOEL DE SOPHIE</a>
                <a href="index.php#collection" class="back-btn">
                    &#8592; Retour a la collection
                </a>
            </div>
        </div>
    </header>

    <section class="product-detail">
        <div class="container">
            <div class="product-grid">
                <div class="product-image-container">
                    <?php if (!empty($product['badge'])): ?>
                        <span class="product-badge-detail"><?= htmlspecialchars($product['badge']) ?></span>
                    <?php endif; ?>
                    <div class="product-main-image">
                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    </div>
                </div>

                <div class="product-info-detail">
                    <div class="product-rating-detail"><?= stars((int) $product['rating']) ?></div>
                    <h1><?= htmlspecialchars($product['name']) ?></h1>

                    <div class="product-price-detail">
                        <?= number_format((float) $product['prix'], 2, ',', ' ') ?> EUR
                    </div>

                    <p class="product-description">
                        <?= nl2br(htmlspecialchars($product['description_longue'])) ?>
                    </p>

                    <div class="product-specs">
                        <h3>Caracteristiques</h3>
                        <?php if (!empty($product['dimensions'])): ?>
                            <div class="spec-item">
                                <span class="spec-label">Dimensions</span>
                                <span class="spec-value"><?= htmlspecialchars($product['dimensions']) ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($product['materiau'])): ?>
                            <div class="spec-item">
                                <span class="spec-label">Materiau</span>
                                <span class="spec-value"><?= htmlspecialchars($product['materiau']) ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($product['inclus'])): ?>
                            <div class="spec-item">
                                <span class="spec-label">Contenu</span>
                                <span class="spec-value"><?= htmlspecialchars($product['inclus']) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <a href="index.php#contact" class="contact-cta">Nous contacter pour cette piece</a>

                    <div class="product-features">
                        <div class="feature-item">
                            <div class="feature-icon">&#127809;</div>
                            <div class="feature-text">Fabrication artisanale francaise</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">&#128230;</div>
                            <div class="feature-text">Emballage soigne</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">&#10084;</div>
                            <div class="feature-text">Piece d'exception</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-content">
                <p>&copy; <?= date('Y') ?> Noel de Sophie - Tous droits reserves | Fabrique avec passion</p>
            </div>
        </div>
    </footer>
</body>
</html>
