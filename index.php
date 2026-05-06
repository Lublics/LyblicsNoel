<?php
require_once __DIR__ . '/includes/db.php';

$products = getProducts();

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
    <title>Noel de Sophie - Decorations Artisanales</title>
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
            --success: #27ae60;
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

        .announcement-banner {
            background: var(--primary-blue);
            color: var(--white);
            text-align: center;
            padding: 12px 20px;
            font-size: 0.9rem;
        }

        .announcement-banner strong { color: var(--gold); }

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
            flex-wrap: wrap;
            gap: 1rem;
        }

        .logo {
            font-family: 'Tenor Sans', serif;
            font-size: 1.8rem;
            text-decoration: none;
            color: var(--primary-blue);
            letter-spacing: 2px;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .nav-links a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 400;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--gold);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after { width: 100%; }
        .nav-links a:hover { color: var(--gold); }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--primary-blue);
            cursor: pointer;
        }

        .hero {
            background: linear-gradient(rgba(15, 66, 112, 0.7), rgba(15, 66, 112, 0.7)),
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><defs><radialGradient id="g1" cx="50%" cy="50%"><stop offset="0%" stop-color="%23c9a959"/><stop offset="100%" stop-color="%230f4270"/></radialGradient></defs><rect fill="url(%23g1)" width="1200" height="600"/></svg>');
            background-size: cover;
            background-position: center;
            color: var(--white);
            text-align: center;
            padding: 8rem 0;
            position: relative;
        }

        .hero-content { position: relative; z-index: 1; }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            letter-spacing: 3px;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            font-weight: 300;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-button {
            display: inline-block;
            background: var(--gold);
            color: var(--white);
            padding: 15px 40px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .cta-button:hover {
            background: var(--white);
            color: var(--primary-blue);
        }

        .section { padding: 5rem 0; }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--primary-blue);
            letter-spacing: 2px;
        }

        .section-subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 2rem;
            font-weight: 300;
        }

        .collection-description {
            max-width: 900px;
            margin: 0 auto 3rem auto;
            text-align: center;
            padding: 2rem;
            background: var(--white);
            border-left: 4px solid var(--gold);
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .collection-description p {
            color: #555;
            font-size: 1.05rem;
            line-height: 1.8;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .product-card {
            background: var(--white);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        }

        .product-image {
            height: 280px;
            background: linear-gradient(135deg, var(--primary-blue), #1a5a8a);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image img { transform: scale(1.05); }

        .product-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--gold);
            color: var(--white);
            padding: 5px 12px;
            font-size: 0.75rem;
            letter-spacing: 1px;
            z-index: 1;
        }

        .product-info { padding: 1.5rem; }

        .product-info h3 {
            color: var(--primary-blue);
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
        }

        .product-info p {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .product-rating {
            color: var(--gold);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--light-gray);
        }

        .price-amount {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary-blue);
        }

        .product-cta {
            background: var(--primary-blue);
            color: var(--white);
            padding: 8px 18px;
            font-size: 0.85rem;
            letter-spacing: 1px;
            transition: background 0.3s ease;
        }

        .product-card:hover .product-cta { background: var(--gold); }

        .contact-section { background: var(--white); }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
        }

        .contact-info h3 {
            color: var(--primary-blue);
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        .contact-info p {
            margin-bottom: 1rem;
            color: #666;
        }

        .contact-details { margin-top: 2rem; }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 1rem;
            padding: 1rem;
            background: var(--cream);
        }

        .contact-item-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-blue);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .form-container {
            background: var(--cream);
            padding: 2.5rem;
        }

        .form-container h3 {
            color: var(--primary-blue);
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        .form-group { margin-bottom: 1.5rem; }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark-text);
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 14px;
            border: 1px solid var(--light-gray);
            background: var(--white);
            font-size: 1rem;
            font-family: 'Lato', sans-serif;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary-blue);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .submit-btn {
            background: var(--primary-blue);
            color: var(--white);
            padding: 15px 40px;
            border: none;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 1px;
            width: 100%;
        }

        .submit-btn:hover { background: var(--gold); }
        .submit-btn:disabled { background: #999; cursor: not-allowed; }

        .form-error {
            padding: 1rem;
            margin-bottom: 1rem;
            background: #f8d7da;
            border-left: 4px solid #c0392b;
            color: #721c24;
            font-size: 0.9rem;
        }

        footer {
            background: var(--primary-blue);
            color: var(--white);
            padding: 4rem 0 2rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .footer-col h4 {
            color: var(--gold);
            margin-bottom: 1.5rem;
            font-size: 1rem;
            letter-spacing: 1px;
        }

        .footer-col a {
            display: block;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            margin-bottom: 0.8rem;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .footer-col a:hover { color: var(--gold); }

        .footer-col p {
            color: rgba(255,255,255,0.7);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 2rem;
            text-align: center;
            color: rgba(255,255,255,0.5);
            font-size: 0.85rem;
        }

        .modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.7);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
        }

        .modal-overlay.show { display: flex; }

        .modal-content {
            background: var(--white);
            padding: 3rem;
            max-width: 500px;
            text-align: center;
        }

        .modal-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .modal-content h3 {
            color: var(--primary-blue);
            margin-bottom: 1rem;
        }

        .modal-content p {
            color: #666;
            margin-bottom: 2rem;
        }

        .modal-close {
            background: var(--primary-blue);
            color: var(--white);
            border: none;
            padding: 12px 30px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .modal-close:hover { background: var(--gold); }

        @media (max-width: 992px) {
            .contact-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .nav-links.mobile-open {
                display: flex;
                flex-direction: column;
                width: 100%;
            }
            .mobile-menu-btn { display: block; }
            .hero h1 { font-size: 2.5rem; }
            .form-row { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="announcement-banner">
        Decouvrez nos creations artisanales | <strong>Fabrication francaise</strong>
    </div>

    <header>
        <div class="container">
            <div class="header-content">
                <a href="#" class="logo">NOEL DE SOPHIE</a>
                <button class="mobile-menu-btn" onclick="toggleMobileMenu()">&#9776;</button>
                <nav class="nav-links" id="navLinks">
                    <a href="#accueil">Accueil</a>
                    <a href="#collection">Collection</a>
                    <a href="#contact">Contact</a>
                </nav>
            </div>
        </div>
    </header>

    <section class="hero" id="accueil">
        <div class="container hero-content">
            <h1>Boules de Noel de Sophie</h1>
            <p>Decorations soufflees a la main, fabriquees en France depuis 1920. Chaque piece est unique et temoigne d'un savoir-faire ancestral.</p>
            <a href="#collection" class="cta-button">Decouvrir la Collection</a>
        </div>
    </section>

    <section class="section" id="collection">
        <div class="container">
            <h2 class="section-title">Notre Collection</h2>
            <p class="section-subtitle">Des decorations d'exception pour sublimer vos fetes</p>

            <div class="collection-description">
                <p>Decouvrez notre collection exclusive de boules en cristal avec gravure laser 3D. Chaque piece est un veritable chef-d'oeuvre artisanal, representant des divinites bouddhistes et des danseuses classiques. Fabriquees avec un cristal K9 de haute qualite, ces boules sont livrees avec un elegant socle en bois naturel equipe d'un eclairage LED qui illumine la gravure et cree une ambiance feerique. Parfaites comme decoration d'interieur, cadeau spirituel ou piece de collection.</p>
            </div>

            <div class="products-grid">
                <?php foreach ($products as $p): ?>
                    <a href="product.php?id=<?= htmlspecialchars($p['slug']) ?>" class="product-link">
                        <div class="product-card">
                            <div class="product-image">
                                <?php if (!empty($p['badge'])): ?>
                                    <span class="product-badge"><?= htmlspecialchars($p['badge']) ?></span>
                                <?php endif; ?>
                                <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                            </div>
                            <div class="product-info">
                                <div class="product-rating"><?= stars((int) $p['rating']) ?></div>
                                <h3><?= htmlspecialchars($p['name']) ?></h3>
                                <p><?= htmlspecialchars($p['description_courte']) ?></p>
                                <div class="product-footer">
                                    <span class="price-amount"><?= number_format((float) $p['prix'], 2, ',', ' ') ?> EUR</span>
                                    <span class="product-cta">Voir</span>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section contact-section" id="contact">
        <div class="container">
            <h2 class="section-title">Contactez-nous</h2>
            <p class="section-subtitle">Notre equipe est a votre disposition pour toute question</p>

            <div class="contact-grid">
                <div class="contact-info">
                    <h3>Nos Coordonnees</h3>
                    <p>N'hesitez pas a nous contacter pour toute demande d'information sur nos produits ou nos creations personnalisees.</p>

                    <div class="contact-details">
                        <div class="contact-item">
                            <div class="contact-item-icon">&#128222;</div>
                            <div><strong>Telephone</strong><br>01 23 45 67 89</div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-item-icon">&#9993;</div>
                            <div><strong>Email</strong><br>contact@noeldesophie.fr</div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-item-icon">&#128205;</div>
                            <div><strong>Adresse</strong><br>12 Rue des Artisans<br>75001 Paris, France</div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-item-icon">&#128344;</div>
                            <div><strong>Horaires</strong><br>Lun-Ven: 9h-18h<br>Sam: 10h-16h</div>
                        </div>
                    </div>
                </div>

                <div class="form-container">
                    <h3>Envoyez-nous un message</h3>
                    <div id="formError" class="form-error" style="display: none;"></div>
                    <form id="contactForm" action="contact.php" method="post">
                        <div style="position: absolute; left: -9999px;" aria-hidden="true">
                            <label for="website">Ne pas remplir</label>
                            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="contact-nom">Nom *</label>
                                <input type="text" id="contact-nom" name="nom" required maxlength="100">
                            </div>
                            <div class="form-group">
                                <label for="contact-prenom">Prenom *</label>
                                <input type="text" id="contact-prenom" name="prenom" required maxlength="100">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contact-email">Email *</label>
                            <input type="email" id="contact-email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="contact-telephone">Telephone</label>
                            <input type="tel" id="contact-telephone" name="telephone" maxlength="30">
                        </div>
                        <div class="form-group">
                            <label for="contact-sujet">Sujet *</label>
                            <select id="contact-sujet" name="sujet" required>
                                <option value="">Selectionnez un sujet...</option>
                                <option value="information">Demande d'information</option>
                                <option value="personnalisation">Personnalisation</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="contact-message">Votre message *</label>
                            <textarea id="contact-message" name="message" rows="5" required minlength="5" maxlength="5000" placeholder="Decrivez votre demande..."></textarea>
                        </div>
                        <button type="submit" class="submit-btn" id="submitBtn">Envoyer le Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4>NOEL DE SOPHIE</h4>
                    <p>Createur de decorations de Noel artisanales depuis 1920.</p>
                    <p>Savoir-faire francais, pieces uniques soufflees a la main.</p>
                </div>
                <div class="footer-col">
                    <h4>NAVIGATION</h4>
                    <a href="#accueil">Accueil</a>
                    <a href="#collection">Collection</a>
                    <a href="#contact">Contact</a>
                </div>
                <div class="footer-col">
                    <h4>INFORMATIONS</h4>
                    <a href="#">Mentions legales</a>
                    <a href="#">Politique de confidentialite</a>
                </div>
                <div class="footer-col">
                    <h4>CONTACT</h4>
                    <p>&#128222; 01 23 45 67 89</p>
                    <p>&#9993; contact@noeldesophie.fr</p>
                    <p>&#128205; 12 Rue des Artisans, 75001 Paris</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> Noel de Sophie - Tous droits reserves | Fabrique avec passion</p>
            </div>
        </div>
    </footer>

    <div class="modal-overlay" id="successModal">
        <div class="modal-content">
            <div class="modal-icon">&#10004;</div>
            <h3>Message Envoye !</h3>
            <p>Votre message a bien ete envoye. Nous vous repondrons dans les plus brefs delais.</p>
            <button class="modal-close" onclick="closeModal()">Fermer</button>
        </div>
    </div>

    <script>
        function toggleMobileMenu() {
            document.getElementById('navLinks').classList.toggle('mobile-open');
        }

        function closeModal() {
            document.getElementById('successModal').classList.remove('show');
        }

        document.getElementById('contactForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = this;
            const btn = document.getElementById('submitBtn');
            const errBox = document.getElementById('formError');
            errBox.style.display = 'none';
            btn.disabled = true;
            btn.textContent = 'Envoi...';

            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: { 'Accept': 'application/json' }
                });
                const data = await res.json();

                if (res.ok && data.ok) {
                    document.getElementById('successModal').classList.add('show');
                    form.reset();
                } else {
                    const msg = (data.errors && data.errors.join(' ')) || data.error || 'Erreur lors de l\'envoi.';
                    errBox.textContent = msg;
                    errBox.style.display = 'block';
                }
            } catch (err) {
                errBox.textContent = 'Connexion impossible. Reessayez plus tard.';
                errBox.style.display = 'block';
            } finally {
                btn.disabled = false;
                btn.textContent = 'Envoyer le Message';
            }
        });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>
