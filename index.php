<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noel de Sophie - Decorations Artisanales</title>
    <link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&family=Lato:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-blue: #0f4270;
            --cream: #f5f2ee;
            --gold: #c9a959;
            --dark-text: #2c3e50;
            --light-gray: #e8e5e0;
            --white: #ffffff;
            --success: #27ae60;
            --error: #e74c3c;
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

        /* Announcement Banner */
        .announcement-banner {
            background: var(--primary-blue);
            color: var(--white);
            text-align: center;
            padding: 12px 20px;
            font-size: 0.9rem;
        }

        .announcement-banner strong {
            color: var(--gold);
        }

        /* Header */
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

        .nav-links a:hover::after {
            width: 100%;
        }

        .nav-links a:hover {
            color: var(--gold);
        }

        .client-type-nav {
            display: flex;
            gap: 10px;
        }

        .client-btn {
            padding: 10px 20px;
            background: transparent;
            border: 1px solid var(--primary-blue);
            color: var(--primary-blue);
            text-decoration: none;
            font-size: 0.85rem;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .client-btn:hover, .client-btn.active {
            background: var(--primary-blue);
            color: var(--white);
        }

        .cart-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: var(--gold);
            color: var(--white);
            border: none;
            font-size: 0.85rem;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            font-family: 'Lato', sans-serif;
        }

        .cart-btn:hover {
            background: var(--primary-blue);
        }

        .cart-count {
            background: var(--white);
            color: var(--primary-blue);
            font-size: 0.75rem;
            font-weight: 600;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .cart-count:empty {
            display: none;
        }

        /* Mobile Menu */
        .mobile-header-actions {
            display: none;
            align-items: center;
            gap: 10px;
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--primary-blue);
            cursor: pointer;
        }

        /* Hero Section */
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

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="%23ffffff" opacity="0.1"/></svg>');
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

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

        /* Section Styles */
        .section {
            padding: 5rem 0;
        }

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

        /* Products Grid */
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
            font-size: 5rem;
            position: relative;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .product-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .product-card {
            cursor: pointer;
        }

        .product-image::before {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0%, 100% { transform: translate(-50%, -50%) rotate(0deg); }
            50% { transform: translate(-50%, -50%) rotate(180deg); }
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
        }

        .product-info {
            padding: 1.5rem;
        }

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

        .product-price {
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

        .price-pro {
            font-size: 0.85rem;
            color: var(--gold);
            font-weight: 600;
        }

        .add-to-cart {
            background: var(--primary-blue);
            color: var(--white);
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }

        .add-to-cart:hover {
            background: var(--gold);
        }

        /* Filter Section */
        .filter-section {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 10px 25px;
            background: transparent;
            border: 1px solid var(--primary-blue);
            color: var(--primary-blue);
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .filter-btn:hover, .filter-btn.active {
            background: var(--primary-blue);
            color: var(--white);
        }

        /* Contact Section */
        .contact-section {
            background: var(--white);
        }

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

        .contact-details {
            margin-top: 2rem;
        }

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
        }

        /* Form Styles */
        .form-container {
            background: var(--cream);
            padding: 2.5rem;
        }

        .form-container h3 {
            color: var(--primary-blue);
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

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

        .submit-btn:hover {
            background: var(--gold);
        }

        /* Order Section - Enterprise */
        .order-section {
            background: var(--primary-blue);
            color: var(--white);
        }

        .order-section .section-title {
            color: var(--white);
        }

        .order-section .section-subtitle {
            color: rgba(255,255,255,0.7);
        }

        .order-container {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 3rem;
        }

        .cart-summary {
            background: rgba(255,255,255,0.1);
            padding: 2rem;
        }

        .cart-summary h3 {
            color: var(--gold);
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .cart-item-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .cart-item-qty {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .qty-btn {
            width: 25px;
            height: 25px;
            background: var(--gold);
            border: none;
            color: var(--white);
            cursor: pointer;
            font-size: 1rem;
        }

        .cart-item-remove {
            background: none;
            border: none;
            color: rgba(255,255,255,0.5);
            cursor: pointer;
            font-size: 1.2rem;
        }

        .cart-item-remove:hover {
            color: var(--error);
        }

        .cart-total {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 2px solid var(--gold);
        }

        .cart-total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .cart-total-row.final {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--gold);
            margin-top: 1rem;
        }

        .enterprise-form {
            background: var(--white);
            padding: 2.5rem;
            color: var(--dark-text);
        }

        .enterprise-form h3 {
            color: var(--primary-blue);
            margin-bottom: 0.5rem;
        }

        .enterprise-form .form-subtitle {
            color: #666;
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }

        .form-section-title {
            color: var(--primary-blue);
            font-size: 1.1rem;
            margin: 2rem 0 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--light-gray);
        }

        .form-section-title:first-of-type {
            margin-top: 0;
        }

        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 1rem;
        }

        .checkbox-group input[type="checkbox"] {
            width: auto;
            margin-top: 3px;
        }

        .checkbox-group label {
            font-weight: 400;
            font-size: 0.9rem;
            color: #666;
        }

        /* Footer */
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

        .footer-col a:hover {
            color: var(--gold);
        }

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

        /* Notification */
        .notification {
            position: fixed;
            top: 100px;
            right: 20px;
            background: var(--success);
            color: var(--white);
            padding: 15px 25px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            z-index: 1000;
            transform: translateX(400px);
            opacity: 0;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .notification.show {
            transform: translateX(0);
            opacity: 1;
        }

        .notification .close-btn {
            background: none;
            border: none;
            color: var(--white);
            font-size: 1.2rem;
            cursor: pointer;
            margin-left: 10px;
        }

        /* Empty cart message */
        .empty-cart {
            text-align: center;
            padding: 2rem;
            color: rgba(255,255,255,0.5);
        }

        /* Success Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.7);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
        }

        .modal-overlay.show {
            display: flex;
        }

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

        .modal-close:hover {
            background: var(--gold);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .contact-grid,
            .order-container {
                grid-template-columns: 1fr;
            }

            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .nav-links.mobile-open {
                display: flex;
                flex-direction: column;
                width: 100%;
            }

            .nav-links .cart-btn {
                display: none;
            }

            .mobile-header-actions {
                display: flex;
            }

            .mobile-menu-btn {
                display: block;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .client-type-nav {
                width: 100%;
                justify-content: center;
            }
        }

        /* Utility classes */
        .hidden {
            display: none !important;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Announcement Banner -->
    <div class="announcement-banner">
        Commandes passees <strong>avant le 15 decembre</strong> expediees pour Noel | Livraison offerte des 100EUR
    </div>

    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-content">
                <a href="#" class="logo">NOEL DE SOPHIE</a>
                <div class="mobile-header-actions">
                    <button class="cart-btn mobile-cart-btn" onclick="scrollToCart()">&#128722; <span class="cart-count" id="cartCountMobile"></span></button>
                    <button class="mobile-menu-btn" onclick="toggleMobileMenu()">&#9776;</button>
                </div>
                <nav class="nav-links" id="navLinks">
                    <a href="#accueil">Accueil</a>
                    <a href="#collection">Collection</a>
                    <a href="#contact">Contact</a>
                    <a href="#commander">Commander</a>
                    <button class="cart-btn" onclick="scrollToCart()">&#128722; Panier <span class="cart-count" id="cartCount"></span></button>
                    <div class="client-type-nav">
                        <button class="client-btn active" onclick="switchClientType('particulier', this)">Particulier</button>
                        <button class="client-btn" onclick="switchClientType('professionnel', this)">Professionnel</button>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="accueil">
        <div class="container hero-content">
            <h1>Boules de Noel de Sophie</h1>
            <p>Decorations soufflees a la main, fabriquees en France depuis 1920. Chaque piece est unique et temoigne d'un savoir-faire ancestral.</p>
            <a href="#collection" class="cta-button">Decouvrir la Collection</a>
        </div>
    </section>

    <!-- Collection Section -->
    <section class="section" id="collection">
        <div class="container">
            <h2 class="section-title">Notre Collection</h2>
            <p class="section-subtitle">Des decorations d'exception pour sublimer vos fetes</p>

            <div class="collection-description">
                <p>Decouvrez notre collection exclusive de boules en cristal avec gravure laser 3D. Chaque piece est un veritable chef-d'oeuvre artisanal, representant des divinites bouddhistes et des danseuses classiques. Fabriquees avec un cristal K9 de haute qualite, ces boules sont livrees avec un elegant socle en bois naturel equipe d'un eclairage LED qui illumine la gravure et cree une ambiance feerique. Parfaites comme decoration d'interieur, cadeau spirituel ou piece de collection.</p>
            </div>

            <div class="products-grid" id="productsGrid">
                <!-- Cristal 3D - Product 1 (PDF #1) -->
                <a href="product.php?id=cristal-01" class="product-link">
                    <div class="product-card" data-category="cristal">
                        <div class="product-image">
                            <span class="product-badge">NOUVEAUTE</span>
                            <img src="images/cristal_01.png" alt="Boule Cristal Vajrapani">
                        </div>
                        <div class="product-info">
                            <div class="product-rating">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                            <h3>Boule Cristal Vajrapani</h3>
                            <p>Boule en cristal avec gravure laser 3D representant le gardien protecteur. Socle bois lumineux LED. Diametre 8cm.</p>
                            <div class="product-price">
                                <div>
                                    <span class="price-amount particulier-price">45,00 EUR</span>
                                    <span class="price-pro pro-price hidden">38,00 EUR HT</span>
                                </div>
                                <span class="add-to-cart">Voir</span>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Cristal 3D - Product 2 (PDF #3) -->
                <a href="product.php?id=cristal-03" class="product-link">
                    <div class="product-card" data-category="cristal">
                        <div class="product-image">
                            <img src="images/cristal_03.png" alt="Boule Cristal Chenrezig">
                        </div>
                        <div class="product-info">
                            <div class="product-rating">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                            <h3>Boule Cristal Chenrezig</h3>
                            <p>Bodhisattva de la compassion avec aureole elaboree, grave au laser 3D. Socle bois lumineux LED. Diametre 8cm.</p>
                            <div class="product-price">
                                <div>
                                    <span class="price-amount particulier-price">42,00 EUR</span>
                                    <span class="price-pro pro-price hidden">35,00 EUR HT</span>
                                </div>
                                <span class="add-to-cart">Voir</span>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Cristal 3D - Product 3 (PDF #7) -->
                <a href="product.php?id=cristal-07" class="product-link">
                    <div class="product-card" data-category="cristal">
                        <div class="product-image">
                            <span class="product-badge">BEST-SELLER</span>
                            <img src="images/cristal_07.png" alt="Boule Cristal Guanyin">
                        </div>
                        <div class="product-info">
                            <div class="product-rating">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                            <h3>Boule Cristal Guanyin</h3>
                            <p>Deesse de la misericorde tenant une fleur de lotus, gravure laser 3D. Symbole de compassion. Diametre 8cm.</p>
                            <div class="product-price">
                                <div>
                                    <span class="price-amount particulier-price">52,00 EUR</span>
                                    <span class="price-pro pro-price hidden">43,00 EUR HT</span>
                                </div>
                                <span class="add-to-cart">Voir</span>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Cristal 3D - Product 4 (PDF #12) -->
                <a href="product.php?id=cristal-12" class="product-link">
                    <div class="product-card" data-category="cristal">
                        <div class="product-image">
                            <img src="images/cristal_12.png" alt="Boule Cristal Samantabhadra">
                        </div>
                        <div class="product-info">
                            <div class="product-rating">&#9733;&#9733;&#9733;&#9733;&#9734;</div>
                            <h3>Boule Cristal Samantabhadra</h3>
                            <p>Bodhisattva de la pratique sur son elephant blanc, gravure laser 3D. Piece spirituelle. Diametre 8cm.</p>
                            <div class="product-price">
                                <div>
                                    <span class="price-amount particulier-price">39,00 EUR</span>
                                    <span class="price-pro pro-price hidden">32,00 EUR HT</span>
                                </div>
                                <span class="add-to-cart">Voir</span>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Cristal 3D - Product 5 (PDF #14) -->
                <a href="product.php?id=cristal-14" class="product-link">
                    <div class="product-card" data-category="cristal">
                        <div class="product-image">
                            <span class="product-badge">EDITION LIMITEE</span>
                            <img src="images/cristal_14.png" alt="Boule Cristal Avalokiteshvara">
                        </div>
                        <div class="product-info">
                            <div class="product-rating">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                            <h3>Boule Cristal Avalokiteshvara</h3>
                            <p>Divinite aux mille bras, symbole de compassion universelle. Gravure laser 3D exceptionnelle. Diametre 8cm.</p>
                            <div class="product-price">
                                <div>
                                    <span class="price-amount particulier-price">68,00 EUR</span>
                                    <span class="price-pro pro-price hidden">56,00 EUR HT</span>
                                </div>
                                <span class="add-to-cart">Voir</span>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Cristal 3D - Product 6 (PDF #15) -->
                <a href="product.php?id=cristal-15" class="product-link">
                    <div class="product-card" data-category="cristal">
                        <div class="product-image">
                            <img src="images/cristal_15.png" alt="Boule Cristal Mille Bras">
                        </div>
                        <div class="product-info">
                            <div class="product-rating">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                            <h3>Boule Cristal Mille Bras</h3>
                            <p>Avalokiteshvara debout aux mille bras protecteurs. Chef-d'oeuvre de gravure laser 3D. Diametre 8cm.</p>
                            <div class="product-price">
                                <div>
                                    <span class="price-amount particulier-price">58,00 EUR</span>
                                    <span class="price-pro pro-price hidden">48,00 EUR HT</span>
                                </div>
                                <span class="add-to-cart">Voir</span>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Cristal 3D - Product 7 (PDF #17) -->
                <a href="product.php?id=cristal-17" class="product-link">
                    <div class="product-card" data-category="cristal">
                        <div class="product-image">
                            <span class="product-badge">NOUVEAUTE</span>
                            <img src="images/cristal_17.png" alt="Boule Cristal Tara Verte">
                        </div>
                        <div class="product-info">
                            <div class="product-rating">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                            <h3>Boule Cristal Tara Verte</h3>
                            <p>Bodhisattva feminin de la compassion active avec aureole rayonnante. Gravure laser 3D. Diametre 8cm.</p>
                            <div class="product-price">
                                <div>
                                    <span class="price-amount particulier-price">44,00 EUR</span>
                                    <span class="price-pro pro-price hidden">36,00 EUR HT</span>
                                </div>
                                <span class="add-to-cart">Voir</span>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Cristal 3D - Product 8 (PDF #19) -->
                <a href="product.php?id=cristal-19" class="product-link">
                    <div class="product-card" data-category="cristal">
                        <div class="product-image">
                            <img src="images/cristal_19.png" alt="Boule Cristal Manjushri">
                        </div>
                        <div class="product-info">
                            <div class="product-rating">&#9733;&#9733;&#9733;&#9733;&#9734;</div>
                            <h3>Boule Cristal Manjushri</h3>
                            <p>Bodhisattva de la sagesse avec couronne et aureole. Gravure laser 3D detaillee. Diametre 8cm.</p>
                            <div class="product-price">
                                <div>
                                    <span class="price-amount particulier-price">44,00 EUR</span>
                                    <span class="price-pro pro-price hidden">36,00 EUR HT</span>
                                </div>
                                <span class="add-to-cart">Voir</span>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Cristal 3D - Product 9 (PDF #23) -->
                <a href="product.php?id=cristal-23" class="product-link">
                    <div class="product-card" data-category="cristal">
                        <div class="product-image">
                            <span class="product-badge">BEST-SELLER</span>
                            <img src="images/cristal_23.png" alt="Boule Cristal Ballerine Classique">
                        </div>
                        <div class="product-info">
                            <div class="product-rating">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                            <h3>Boule Cristal Ballerine Classique</h3>
                            <p>Elegante danseuse classique bras leves, gravee au laser 3D. Cadeau ideal pour passionnes de danse. Diametre 8cm.</p>
                            <div class="product-price">
                                <div>
                                    <span class="price-amount particulier-price">48,00 EUR</span>
                                    <span class="price-pro pro-price hidden">40,00 EUR HT</span>
                                </div>
                                <span class="add-to-cart">Voir</span>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Cristal 3D - Product 10 (PDF #24) -->
                <a href="product.php?id=cristal-24" class="product-link">
                    <div class="product-card" data-category="cristal">
                        <div class="product-image">
                            <img src="images/cristal_24.png" alt="Boule Cristal Danseuse Etoile">
                        </div>
                        <div class="product-info">
                            <div class="product-rating">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                            <h3>Boule Cristal Danseuse Etoile</h3>
                            <p>Danseuse etoile en tutu, chef-d'oeuvre de gravure laser 3D. Socle bois naturel avec LED. Diametre 8cm.</p>
                            <div class="product-price">
                                <div>
                                    <span class="price-amount particulier-price">46,00 EUR</span>
                                    <span class="price-pro pro-price hidden">38,00 EUR HT</span>
                                </div>
                                <span class="add-to-cart">Voir</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section contact-section" id="contact">
        <div class="container">
            <h2 class="section-title">Contactez-nous</h2>
            <p class="section-subtitle">Notre equipe est a votre disposition pour toute question</p>

            <div class="contact-grid">
                <div class="contact-info">
                    <h3>Nos Coordonnees</h3>
                    <p>N'hesitez pas a nous contacter pour toute demande d'information sur nos produits, les commandes personnalisees ou les conditions professionnelles.</p>

                    <div class="contact-details">
                        <div class="contact-item">
                            <div class="contact-item-icon">&#128222;</div>
                            <div>
                                <strong>Telephone</strong><br>
                                01 23 45 67 89
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-item-icon">&#9993;</div>
                            <div>
                                <strong>Email</strong><br>
                                contact@noeldesophie.fr
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-item-icon">&#128205;</div>
                            <div>
                                <strong>Adresse</strong><br>
                                12 Rue des Artisans<br>
                                75001 Paris, France
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-item-icon">&#128344;</div>
                            <div>
                                <strong>Horaires</strong><br>
                                Lun-Ven: 9h-18h<br>
                                Sam: 10h-16h
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-container">
                    <h3>Envoyez-nous un message</h3>
                    <form id="contactForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="contact-nom">Nom *</label>
                                <input type="text" id="contact-nom" name="nom" required>
                            </div>
                            <div class="form-group">
                                <label for="contact-prenom">Prenom *</label>
                                <input type="text" id="contact-prenom" name="prenom" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contact-email">Email *</label>
                            <input type="email" id="contact-email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="contact-telephone">Telephone</label>
                            <input type="tel" id="contact-telephone" name="telephone">
                        </div>
                        <div class="form-group">
                            <label for="contact-sujet">Sujet *</label>
                            <select id="contact-sujet" name="sujet" required>
                                <option value="">Selectionnez un sujet...</option>
                                <option value="information">Demande d'information</option>
                                <option value="commande">Question sur une commande</option>
                                <option value="professionnel">Demande professionnelle</option>
                                <option value="personnalisation">Personnalisation</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="contact-message">Votre message *</label>
                            <textarea id="contact-message" name="message" rows="5" required placeholder="Decrivez votre demande..."></textarea>
                        </div>
                        <button type="submit" class="submit-btn">Envoyer le Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Order Section (Enterprise) -->
    <section class="section order-section" id="commander">
        <div class="container">
            <h2 class="section-title">Passer Commande</h2>
            <p class="section-subtitle">Particuliers et professionnels, finalisez votre commande ici</p>

            <div class="order-container">
                <!-- Cart Summary -->
                <div class="cart-summary">
                    <h3>Votre Panier</h3>
                    <div id="cartItems">
                        <div class="empty-cart">Votre panier est vide</div>
                    </div>
                    <div class="cart-total" id="cartTotalSection" style="display: none;">
                        <div class="cart-total-row">
                            <span>Sous-total HT</span>
                            <span id="subtotalHT">0,00 EUR</span>
                        </div>
                        <div class="cart-total-row">
                            <span>TVA (20%)</span>
                            <span id="tvaAmount">0,00 EUR</span>
                        </div>
                        <div class="cart-total-row final">
                            <span>Total TTC</span>
                            <span id="totalTTC">0,00 EUR</span>
                        </div>
                    </div>
                </div>

                <!-- Enterprise Order Form -->
                <div class="enterprise-form">
                    <h3>Formulaire de Commande</h3>
                    <p class="form-subtitle">Remplissez les informations ci-dessous pour valider votre commande</p>

                    <form id="orderForm">
                        <!-- Client Type Info -->
                        <h4 class="form-section-title">Type de Client</h4>
                        <div class="form-group">
                            <select id="order-client-type" name="client_type" required onchange="toggleEnterpriseFields()">
                                <option value="particulier">Particulier</option>
                                <option value="professionnel">Professionnel / Entreprise</option>
                            </select>
                        </div>

                        <!-- Enterprise Fields (hidden by default) -->
                        <div id="enterpriseFields" class="hidden">
                            <h4 class="form-section-title">Informations Entreprise</h4>
                            <div class="form-group">
                                <label for="raison-sociale">Raison Sociale *</label>
                                <input type="text" id="raison-sociale" name="raison_sociale">
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="siret">Numero SIRET *</label>
                                    <input type="text" id="siret" name="siret" placeholder="XXX XXX XXX XXXXX" maxlength="17">
                                </div>
                                <div class="form-group">
                                    <label for="tva-intra">N° TVA Intracommunautaire</label>
                                    <input type="text" id="tva-intra" name="tva_intracommunautaire" placeholder="FRXX XXX XXX XXX">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="code-ape">Code APE/NAF</label>
                                    <input type="text" id="code-ape" name="code_ape" placeholder="XXXXZ">
                                </div>
                                <div class="form-group">
                                    <label for="forme-juridique">Forme Juridique</label>
                                    <select id="forme-juridique" name="forme_juridique">
                                        <option value="">Selectionnez...</option>
                                        <option value="sarl">SARL</option>
                                        <option value="sas">SAS</option>
                                        <option value="sa">SA</option>
                                        <option value="eurl">EURL</option>
                                        <option value="sasu">SASU</option>
                                        <option value="ei">Entreprise Individuelle</option>
                                        <option value="auto">Auto-entrepreneur</option>
                                        <option value="association">Association</option>
                                        <option value="autre">Autre</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Info -->
                        <h4 class="form-section-title">Contact</h4>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="order-civilite">Civilite *</label>
                                <select id="order-civilite" name="civilite" required>
                                    <option value="">Selectionnez...</option>
                                    <option value="m">Monsieur</option>
                                    <option value="mme">Madame</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="order-fonction">Fonction</label>
                                <input type="text" id="order-fonction" name="fonction" placeholder="Ex: Responsable achats">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="order-nom">Nom *</label>
                                <input type="text" id="order-nom" name="nom" required>
                            </div>
                            <div class="form-group">
                                <label for="order-prenom">Prenom *</label>
                                <input type="text" id="order-prenom" name="prenom" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="order-email">Email *</label>
                                <input type="email" id="order-email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="order-telephone">Telephone *</label>
                                <input type="tel" id="order-telephone" name="telephone" required placeholder="01 23 45 67 89">
                            </div>
                        </div>

                        <!-- Billing Address -->
                        <h4 class="form-section-title">Adresse de Facturation</h4>
                        <div class="form-group">
                            <label for="order-adresse">Adresse *</label>
                            <input type="text" id="order-adresse" name="adresse" required>
                        </div>
                        <div class="form-group">
                            <label for="order-adresse2">Complement d'adresse</label>
                            <input type="text" id="order-adresse2" name="adresse2" placeholder="Batiment, etage, etc.">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="order-cp">Code Postal *</label>
                                <input type="text" id="order-cp" name="code_postal" required maxlength="5">
                            </div>
                            <div class="form-group">
                                <label for="order-ville">Ville *</label>
                                <input type="text" id="order-ville" name="ville" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="order-pays">Pays *</label>
                            <select id="order-pays" name="pays" required>
                                <option value="france">France</option>
                                <option value="belgique">Belgique</option>
                                <option value="suisse">Suisse</option>
                                <option value="luxembourg">Luxembourg</option>
                                <option value="allemagne">Allemagne</option>
                                <option value="autre">Autre pays UE</option>
                            </select>
                        </div>

                        <!-- Delivery Options -->
                        <h4 class="form-section-title">Livraison</h4>
                        <div class="checkbox-group">
                            <input type="checkbox" id="same-address" name="same_address" checked onchange="toggleDeliveryAddress()">
                            <label for="same-address">L'adresse de livraison est identique a l'adresse de facturation</label>
                        </div>

                        <div id="deliveryAddressFields" class="hidden">
                            <div class="form-group">
                                <label for="delivery-adresse">Adresse de livraison *</label>
                                <input type="text" id="delivery-adresse" name="delivery_adresse">
                            </div>
                            <div class="form-group">
                                <label for="delivery-adresse2">Complement d'adresse</label>
                                <input type="text" id="delivery-adresse2" name="delivery_adresse2">
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="delivery-cp">Code Postal *</label>
                                    <input type="text" id="delivery-cp" name="delivery_cp" maxlength="5">
                                </div>
                                <div class="form-group">
                                    <label for="delivery-ville">Ville *</label>
                                    <input type="text" id="delivery-ville" name="delivery_ville">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="order-livraison">Mode de livraison *</label>
                            <select id="order-livraison" name="mode_livraison" required>
                                <option value="">Selectionnez...</option>
                                <option value="standard">Livraison standard (3-5 jours) - 6,90 EUR</option>
                                <option value="express">Livraison express (24-48h) - 12,90 EUR</option>
                                <option value="retrait">Retrait en boutique - Gratuit</option>
                            </select>
                        </div>

                        <!-- Comments -->
                        <h4 class="form-section-title">Informations Complementaires</h4>
                        <div class="form-group">
                            <label for="order-commentaires">Commentaires / Instructions speciales</label>
                            <textarea id="order-commentaires" name="commentaires" rows="4" placeholder="Precisions sur votre commande, instructions de livraison..."></textarea>
                        </div>

                        <!-- Payment Info (for Pro) -->
                        <div id="paymentInfo" class="hidden">
                            <h4 class="form-section-title">Modalites de Paiement</h4>
                            <div class="form-group">
                                <label for="order-paiement">Mode de paiement souhaite *</label>
                                <select id="order-paiement" name="mode_paiement">
                                    <option value="">Selectionnez...</option>
                                    <option value="virement">Virement bancaire</option>
                                    <option value="cheque">Cheque</option>
                                    <option value="cb">Carte bancaire</option>
                                    <option value="traite">Traite (sous conditions)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="order-bon-commande">Numero de bon de commande</label>
                                <input type="text" id="order-bon-commande" name="bon_commande" placeholder="Votre reference interne">
                            </div>
                        </div>

                        <!-- Terms -->
                        <div class="checkbox-group" style="margin-top: 2rem;">
                            <input type="checkbox" id="accept-cgv" name="accept_cgv" required>
                            <label for="accept-cgv">J'accepte les <a href="#" style="color: var(--primary-blue);">conditions generales de vente</a> *</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="accept-newsletter" name="newsletter">
                            <label for="accept-newsletter">Je souhaite recevoir les offres et nouveautes par email</label>
                        </div>

                        <button type="submit" class="submit-btn" style="margin-top: 1.5rem;">Valider la Commande</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
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
                    <a href="#commander">Commander</a>
                </div>
                <div class="footer-col">
                    <h4>INFORMATIONS</h4>
                    <a href="#">Conditions generales de vente</a>
                    <a href="#">Politique de confidentialite</a>
                    <a href="#">Mentions legales</a>
                    <a href="#">Livraison & Retours</a>
                </div>
                <div class="footer-col">
                    <h4>CONTACT</h4>
                    <p>&#128222; 01 23 45 67 89</p>
                    <p>&#9993; contact@noeldesophie.fr</p>
                    <p>&#128205; 12 Rue des Artisans, 75001 Paris</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 Noel de Sophie - Tous droits reserves | Fabrique avec passion</p>
            </div>
        </div>
    </footer>

    <!-- Notification -->
    <div id="notification" class="notification">
        <span class="icon">&#10004;</span>
        <span class="message" id="notificationMessage">Article ajoute au panier</span>
        <button class="close-btn" onclick="hideNotification()">&times;</button>
    </div>

    <!-- Success Modal -->
    <div class="modal-overlay" id="successModal">
        <div class="modal-content">
            <div class="modal-icon">&#10004;</div>
            <h3>Commande Envoyee !</h3>
            <p id="modalMessage">Votre commande a bien ete enregistree. Vous recevrez une confirmation par email sous peu.</p>
            <button class="modal-close" onclick="closeModal()">Fermer</button>
        </div>
    </div>

    <script>
        // State
        let currentClientType = 'particulier';
        let cart = JSON.parse(localStorage.getItem('cart') || '[]');

        // Client Type Switching
        function switchClientType(type, btn) {
            currentClientType = type;

            document.querySelectorAll('.client-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            updatePricesDisplay();

            // Update order form
            document.getElementById('order-client-type').value = type;
            toggleEnterpriseFields();
        }

        function updatePricesDisplay() {
            const particulierPrices = document.querySelectorAll('.particulier-price');
            const proPrices = document.querySelectorAll('.pro-price');

            if (currentClientType === 'professionnel') {
                particulierPrices.forEach(el => el.classList.add('hidden'));
                proPrices.forEach(el => el.classList.remove('hidden'));
            } else {
                particulierPrices.forEach(el => el.classList.remove('hidden'));
                proPrices.forEach(el => el.classList.add('hidden'));
            }
        }

        // Product Filtering
        function filterProducts(category, btn) {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const products = document.querySelectorAll('.product-card');
            products.forEach(product => {
                if (category === 'all' || product.dataset.category === category) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        }

        // Cart Functions
        function addToCart(name, priceParticulier, pricePro) {
            const price = currentClientType === 'professionnel' ? pricePro : priceParticulier;

            const existingItem = cart.find(item => item.name === name);

            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    name: name,
                    price: price,
                    priceHT: pricePro,
                    quantity: 1
                });
            }

            updateCartDisplay();
            showNotification(`${name} ajoute au panier`);
        }

        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCartDisplay();
        }

        function updateQuantity(index, change) {
            cart[index].quantity += change;
            if (cart[index].quantity <= 0) {
                removeFromCart(index);
            } else {
                updateCartDisplay();
            }
        }

        function scrollToCart() {
            const target = document.getElementById('commander');
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        function updateCartCount() {
            const total = cart.reduce((sum, item) => sum + item.quantity, 0);
            const text = total > 0 ? total : '';
            document.getElementById('cartCount').textContent = text;
            document.getElementById('cartCountMobile').textContent = text;
        }

        function updateCartDisplay() {
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();

            const cartItemsEl = document.getElementById('cartItems');
            const cartTotalSection = document.getElementById('cartTotalSection');

            if (cart.length === 0) {
                cartItemsEl.innerHTML = '<div class="empty-cart">Votre panier est vide</div>';
                cartTotalSection.style.display = 'none';
                return;
            }

            let html = '';
            let subtotalHT = 0;

            cart.forEach((item, index) => {
                const itemTotal = item.priceHT * item.quantity;
                subtotalHT += itemTotal;

                html += `
                    <div class="cart-item">
                        <div class="cart-item-info">
                            <span>${item.name}</span>
                        </div>
                        <div class="cart-item-qty">
                            <button class="qty-btn" onclick="updateQuantity(${index}, -1)">-</button>
                            <span>${item.quantity}</span>
                            <button class="qty-btn" onclick="updateQuantity(${index}, 1)">+</button>
                            <span style="margin-left: 10px;">${(item.price * item.quantity).toFixed(2)} EUR</span>
                            <button class="cart-item-remove" onclick="removeFromCart(${index})">&times;</button>
                        </div>
                    </div>
                `;
            });

            cartItemsEl.innerHTML = html;

            const tva = subtotalHT * 0.20;
            const totalTTC = subtotalHT + tva;

            document.getElementById('subtotalHT').textContent = subtotalHT.toFixed(2) + ' EUR';
            document.getElementById('tvaAmount').textContent = tva.toFixed(2) + ' EUR';
            document.getElementById('totalTTC').textContent = totalTTC.toFixed(2) + ' EUR';

            cartTotalSection.style.display = 'block';
        }

        // Form Toggle Functions
        function toggleEnterpriseFields() {
            const clientType = document.getElementById('order-client-type').value;
            const enterpriseFields = document.getElementById('enterpriseFields');
            const paymentInfo = document.getElementById('paymentInfo');

            if (clientType === 'professionnel') {
                enterpriseFields.classList.remove('hidden');
                paymentInfo.classList.remove('hidden');

                // Make enterprise fields required
                document.getElementById('raison-sociale').required = true;
                document.getElementById('siret').required = true;
            } else {
                enterpriseFields.classList.add('hidden');
                paymentInfo.classList.add('hidden');

                document.getElementById('raison-sociale').required = false;
                document.getElementById('siret').required = false;
            }
        }

        function toggleDeliveryAddress() {
            const sameAddress = document.getElementById('same-address').checked;
            const deliveryFields = document.getElementById('deliveryAddressFields');

            if (sameAddress) {
                deliveryFields.classList.add('hidden');
            } else {
                deliveryFields.classList.remove('hidden');
            }
        }

        // Notification Functions
        function showNotification(message) {
            const notification = document.getElementById('notification');
            document.getElementById('notificationMessage').textContent = message;
            notification.classList.add('show');

            setTimeout(() => {
                hideNotification();
            }, 3000);
        }

        function hideNotification() {
            document.getElementById('notification').classList.remove('show');
        }

        // Modal Functions
        function showModal(message) {
            document.getElementById('modalMessage').textContent = message;
            document.getElementById('successModal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('successModal').classList.remove('show');
        }

        // Form Submissions
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            showModal('Votre message a bien ete envoye. Nous vous repondrons dans les plus brefs delais.');
            this.reset();
        });

        document.getElementById('orderForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (cart.length === 0) {
                alert('Votre panier est vide. Veuillez ajouter des articles avant de commander.');
                return;
            }

            const clientType = document.getElementById('order-client-type').value;
            let message = 'Votre commande a bien ete enregistree. ';

            if (clientType === 'professionnel') {
                message += 'Notre service commercial vous contactera sous 24h pour confirmer les modalites.';
            } else {
                message += 'Vous recevrez une confirmation par email sous peu.';
            }

            showModal(message);
            this.reset();
            cart = [];
            updateCartDisplay();
            toggleEnterpriseFields();
        });

        // Mobile Menu
        function toggleMobileMenu() {
            const navLinks = document.getElementById('navLinks');
            navLinks.classList.toggle('mobile-open');
        }

        // Smooth Scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // SIRET Formatting
        document.getElementById('siret').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s/g, '').replace(/\D/g, '');
            if (value.length > 14) value = value.slice(0, 14);

            let formatted = '';
            for (let i = 0; i < value.length; i++) {
                if (i > 0 && i % 3 === 0 && i < 9) formatted += ' ';
                if (i === 9) formatted += ' ';
                formatted += value[i];
            }
            e.target.value = formatted;
        });

        // Initialize
        updatePricesDisplay();
        updateCartDisplay();
    </script>
</body>
</html>
