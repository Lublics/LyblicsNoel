<?php
require_once __DIR__ . '/includes/db.php';

$s = getSettings();
$logo  = $s['logo_text'] ?? 'NOEL DE SOPHIE';
$email = $s['contact_email'] ?? '';
$phone = $s['contact_phone'] ?? '';
$addr  = $s['contact_address'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentions legales - <?= htmlspecialchars($logo) ?></title>
    <meta name="robots" content="noindex, follow">
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
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

        .legal {
            max-width: 860px;
            margin: 0 auto;
            padding: 4rem 0;
        }

        .legal-card {
            background: var(--white);
            padding: 3rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        }

        .legal h1 {
            font-size: 2.5rem;
            color: var(--primary-blue);
            margin-bottom: 0.5rem;
            letter-spacing: 1px;
        }

        .legal .updated {
            color: #888;
            font-size: 0.9rem;
            margin-bottom: 2.5rem;
        }

        .legal h2 {
            font-size: 1.4rem;
            color: var(--primary-blue);
            margin: 2.5rem 0 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--gold);
        }

        .legal h2:first-of-type { margin-top: 0; }

        .legal p { margin-bottom: 1rem; color: #555; }

        .legal ul { margin: 0 0 1rem 1.5rem; color: #555; }
        .legal li { margin-bottom: 0.5rem; }

        .legal a { color: var(--primary-blue); }
        .legal a:hover { color: var(--gold); }

        .legal dl { margin-bottom: 1rem; }
        .legal dt { font-weight: 600; color: var(--dark-text); margin-top: 0.75rem; }
        .legal dd { color: #555; margin-left: 0; }

        .todo {
            background: #fff8e6;
            border: 1px dashed var(--gold);
            color: #8a6d1a;
            padding: 1px 6px;
            font-size: 0.9em;
            border-radius: 3px;
        }

        footer {
            background: var(--primary-blue);
            color: var(--white);
            padding: 2rem 0;
        }

        .footer-content {
            text-align: center;
            color: rgba(255,255,255,0.7);
            font-size: 0.9rem;
        }

        .footer-content a {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            margin: 0 0.5rem;
        }

        .footer-content a:hover { color: var(--gold); }

        @media (max-width: 768px) {
            .legal-card { padding: 1.8rem; }
            .legal h1 { font-size: 1.9rem; }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <a href="index.php" class="logo"><?= htmlspecialchars($logo) ?></a>
                <a href="index.php" class="back-btn">&#8592; Retour a l'accueil</a>
            </div>
        </div>
    </header>

    <section class="legal">
        <div class="container">
            <div class="legal-card">
                <h1>Mentions legales</h1>
                <p class="updated">Derniere mise a jour : <?= date('d/m/Y') ?></p>

                <p>
                    Conformement aux dispositions des articles 6-III et 19 de la loi n&deg; 2004-575
                    du 21 juin 2004 pour la confiance dans l'economie numerique (LCEN), il est porte
                    a la connaissance des utilisateurs du site les presentes mentions legales.
                </p>

                <h2>1. Editeur du site</h2>
                <dl>
                    <dt>Raison sociale</dt>
                    <dd>Noel de Sophie</dd>
                    <dt>Forme juridique</dt>
                    <dd>SARL (societe a responsabilite limitee)</dd>
                    <dt>Capital social</dt>
                    <dd>10 000 &euro;</dd>
                    <dt>Siege social</dt>
                    <dd><?= $addr !== '' ? nl2br(htmlspecialchars($addr)) : '<span class="todo">[A COMPLETER : adresse du siege]</span>' ?></dd>
                    <dt>SIREN / SIRET</dt>
                    <dd>892 456 781 00014</dd>
                    <dt>RCS</dt>
                    <dd>RCS Grenoble 892 456 781</dd>
                    <dt>Numero de TVA intracommunautaire</dt>
                    <dd>FR 47 892456781</dd>
                    <dt>Telephone</dt>
                    <dd><?= $phone !== '' ? htmlspecialchars($phone) : '<span class="todo">[A COMPLETER]</span>' ?></dd>
                    <dt>Adresse e-mail</dt>
                    <dd><?php if ($email !== ''): ?><a href="mailto:<?= htmlspecialchars($email) ?>"><?= htmlspecialchars($email) ?></a><?php else: ?><span class="todo">[A COMPLETER]</span><?php endif; ?></dd>
                    <dt>Directeur de la publication</dt>
                    <dd>Lilidjane Pustochin</dd>
                </dl>

                <h2>2. Hebergement</h2>
                <p>Le site est heberge sur un serveur dedie (VPS) administre via Coolify aupres du fournisseur suivant :</p>
                <dl>
                    <dt>Hebergeur</dt>
                    <dd>OVH SAS</dd>
                    <dt>Adresse</dt>
                    <dd>2 rue Kellermann, 59100 Roubaix, France</dd>
                    <dt>Localisation des serveurs</dt>
                    <dd>Datacenter de Strasbourg (France)</dd>
                    <dt>Contact</dt>
                    <dd>Telephone : 1007 &mdash; <a href="https://www.ovhcloud.com" target="_blank" rel="noopener">www.ovhcloud.com</a></dd>
                </dl>

                <h2>3. Propriete intellectuelle</h2>
                <p>
                    L'ensemble des elements composant le site (textes, photographies, illustrations,
                    logos, mise en page, structure, ainsi que les creations artisanales presentees)
                    est protege par le droit d'auteur et le droit de la propriete intellectuelle.
                    Ces elements sont la propriete exclusive de l'editeur, sauf mention contraire.
                </p>
                <p>
                    Toute reproduction, representation, modification, publication ou adaptation de
                    tout ou partie du site, par quelque procede que ce soit, est interdite sans
                    autorisation ecrite prealable de l'editeur. Toute exploitation non autorisee
                    est susceptible de constituer une contrefacon au sens des articles L.335-2 et
                    suivants du Code de la propriete intellectuelle.
                </p>

                <h2>4. Responsabilite</h2>
                <p>
                    L'editeur s'efforce de fournir des informations aussi precises que possible.
                    Toutefois, il ne saurait etre tenu responsable des omissions, inexactitudes ou
                    carences dans la mise a jour, qu'elles soient de son fait ou du fait de tiers
                    partenaires. Les informations presentees sur le site sont donnees a titre
                    indicatif et sont susceptibles d'evoluer.
                </p>
                <p>
                    L'editeur ne saurait etre tenu responsable des dommages directs ou indirects
                    resultant de l'acces au site ou de son utilisation, y compris l'inaccessibilite,
                    les pertes de donnees ou la presence de virus.
                </p>

                <h2>5. Liens hypertextes</h2>
                <p>
                    Le site peut contenir des liens vers d'autres sites. L'editeur n'exerce aucun
                    controle sur ces sites et decline toute responsabilite quant a leur contenu.
                </p>

                <h2>6. Donnees personnelles</h2>
                <p>
                    Le traitement des donnees personnelles collectees via le site (notamment via le
                    formulaire de contact) est detaille dans notre
                    <a href="politique-confidentialite.php">Politique de confidentialite</a>.
                </p>

                <h2>7. Droit applicable</h2>
                <p>
                    Les presentes mentions legales sont regies par le droit francais. En cas de
                    litige et a defaut de resolution amiable, les tribunaux francais seront seuls
                    competents.
                </p>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-content">
                <p>
                    <a href="index.php">Accueil</a> &middot;
                    <a href="mentions-legales.php">Mentions legales</a> &middot;
                    <a href="politique-confidentialite.php">Politique de confidentialite</a>
                </p>
                <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($s['footer_copyright'] ?? $logo) ?></p>
            </div>
        </div>
    </footer>
</body>
</html>
