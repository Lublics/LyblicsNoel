<?php
require_once __DIR__ . '/includes/db.php';

$s = getSettings();
$logo  = $s['logo_text'] ?? 'NOEL DE SOPHIE';
$email = $s['contact_email'] ?? '';
$addr  = $s['contact_address'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Politique de confidentialite - <?= htmlspecialchars($logo) ?></title>
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

        .legal table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        .legal th, .legal td {
            text-align: left;
            padding: 0.75rem;
            border: 1px solid var(--light-gray);
            color: #555;
            vertical-align: top;
        }

        .legal th {
            background: var(--cream);
            color: var(--dark-text);
            font-weight: 600;
        }

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
            .legal table, .legal thead, .legal tbody, .legal th, .legal td, .legal tr {
                display: block;
            }
            .legal th { display: none; }
            .legal td { border: none; border-bottom: 1px solid var(--light-gray); }
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
                <h1>Politique de confidentialite</h1>
                <p class="updated">Derniere mise a jour : <?= date('d/m/Y') ?></p>

                <p>
                    La presente politique decrit la maniere dont sont collectees et traitees vos
                    donnees personnelles lorsque vous utilisez ce site, conformement au Reglement
                    general sur la protection des donnees (RGPD - UE 2016/679) et a la loi
                    Informatique et Libertes du 6 janvier 1978 modifiee.
                </p>

                <h2>1. Responsable du traitement</h2>
                <p>
                    Le responsable du traitement est l'editeur du site, la societe
                    <strong>Noel de Sophie</strong> (SARL), dont les coordonnees figurent dans les
                    <a href="mentions-legales.php">mentions legales</a>.
                </p>
                <p>
                    Pour toute question relative a vos donnees, vous pouvez ecrire a&nbsp;:
                    <?php if ($email !== ''): ?><a href="mailto:<?= htmlspecialchars($email) ?>"><?= htmlspecialchars($email) ?></a><?php else: ?><span class="todo">[A COMPLETER : e-mail de contact]</span><?php endif; ?>.
                </p>

                <h2>2. Donnees collectees et finalites</h2>
                <p>
                    Ce site est un site vitrine. Aucune vente ni paiement n'est realise en ligne.
                    Les donnees sont collectees uniquement lorsque vous remplissez le formulaire
                    de contact.
                </p>
                <table>
                    <thead>
                        <tr>
                            <th>Donnees</th>
                            <th>Finalite</th>
                            <th>Base legale</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Nom, prenom, e-mail, telephone (facultatif), sujet, message</td>
                            <td>Repondre a votre demande de contact</td>
                            <td>Consentement / mesures precontractuelles (art. 6.1.a / 6.1.b RGPD)</td>
                        </tr>
                        <tr>
                            <td>Adresse IP, navigateur (user-agent), date d'envoi</td>
                            <td>Securite du site et prevention des envois abusifs (anti-spam)</td>
                            <td>Interet legitime (art. 6.1.f RGPD)</td>
                        </tr>
                    </tbody>
                </table>
                <p>
                    Les champs marques d'un asterisque dans le formulaire sont obligatoires pour
                    traiter votre demande. Le telephone est facultatif.
                </p>

                <h2>3. Destinataires des donnees</h2>
                <p>
                    Vos donnees sont destinees exclusivement a l'editeur du site et ne sont
                    <strong>ni vendues, ni louees, ni cedees</strong> a des tiers a des fins
                    commerciales. Elles peuvent etre traitees par l'hebergeur du site dans le
                    cadre strict de l'hebergement technique (voir les mentions legales).
                </p>

                <h2>4. Duree de conservation</h2>
                <p>
                    Conformement au principe de minimisation, les donnees ne sont conservees que
                    le temps strictement necessaire. Les messages issus du formulaire de contact
                    sont conserves pendant la duree de traitement de votre demande, puis supprimes
                    au plus tard <strong>12 mois</strong> apres le dernier contact. Les donnees
                    techniques liees a la securite (adresse IP, user-agent) sont conservees pour
                    une duree maximale de <strong>3 mois</strong>.
                </p>

                <h2>5. Hebergement et localisation des donnees</h2>
                <p>
                    Les donnees sont stockees sur le serveur d'hebergement du site, situe en France
                    (datacenter OVH de Strasbourg), au sein de l'Union europeenne. Aucun transfert
                    de donnees en dehors de l'Union europeenne n'est realise.
                </p>

                <h2>6. Cookies</h2>
                <p>
                    Le site public n'utilise <strong>aucun cookie publicitaire ni outil de
                    mesure d'audience</strong> (pas de Google Analytics ou equivalent). Seul un
                    cookie technique de session peut etre utilise dans l'espace d'administration
                    reserve, indispensable a son fonctionnement et exempte de consentement.
                </p>

                <h2>7. Vos droits</h2>
                <p>Conformement au RGPD, vous disposez des droits suivants&nbsp;:</p>
                <ul>
                    <li>droit d'acces a vos donnees ;</li>
                    <li>droit de rectification des donnees inexactes ;</li>
                    <li>droit a l'effacement (droit a l'oubli) ;</li>
                    <li>droit a la limitation du traitement ;</li>
                    <li>droit d'opposition pour motif legitime ;</li>
                    <li>droit a la portabilite de vos donnees.</li>
                </ul>
                <p>
                    Pour exercer ces droits, contactez-nous par e-mail
                    <?php if ($email !== ''): ?>a <a href="mailto:<?= htmlspecialchars($email) ?>"><?= htmlspecialchars($email) ?></a><?php else: ?><span class="todo">[A COMPLETER]</span><?php endif; ?>
                    <?php if ($addr !== ''): ?>ou par courrier a l'adresse du siege social indiquee dans les mentions legales<?php endif; ?>.
                    Une reponse vous sera apportee dans un delai d'un mois.
                </p>

                <h2>8. Reclamation</h2>
                <p>
                    Si vous estimez, apres nous avoir contactes, que vos droits ne sont pas
                    respectes, vous pouvez introduire une reclamation aupres de la CNIL :
                    <a href="https://www.cnil.fr" target="_blank" rel="noopener">www.cnil.fr</a>
                    - 3 Place de Fontenoy, TSA 80715, 75334 Paris Cedex 07.
                </p>

                <h2>9. Modification de la politique</h2>
                <p>
                    La presente politique de confidentialite peut etre modifiee a tout moment afin
                    de rester conforme a la reglementation en vigueur. La date de derniere mise a
                    jour figure en haut de cette page.
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
