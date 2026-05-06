# Dossier projet — LyblicsNoel (Noël de Sophie)

## 1. CONTEXTE DU PROJET

Sophie est une artisane spécialisée dans la création de boules de Noël en cristal gravées au laser 3D, vendues depuis son atelier en France. Elle souhaitait disposer d'un site vitrine permettant de présenter sa collection de pièces uniques (divinités bouddhistes, danseuses classiques, scènes spirituelles), sans pour autant gérer de la vente en ligne ni des commandes complexes. Avant ce projet, sa présence numérique se limitait à des photos partagées par mail et à un PDF imprimé. Elle ne pouvait pas mettre à jour ses produits ni ses tarifs sans solliciter un développeur. La direction a donc demandé la mise en place d'un site web vitrine accompagné d'un panel d'administration permettant à Sophie de gérer elle-même son catalogue, ses textes et les messages reçus depuis le formulaire de contact.

---

## 2. OBJECTIFS

- Présenter de manière professionnelle la collection de boules en cristal artisanales.
- Permettre à l'administratrice de gérer de manière autonome le catalogue produits (ajout, modification, suppression, image, prix, ordre d'affichage, visibilité).
- Permettre la modification de l'ensemble des textes du site (titre, hero, section collection, contact, footer) sans intervention sur le code.
- Offrir un formulaire de contact fonctionnel avec stockage des messages dans une boîte de réception accessible depuis l'admin.
- Sécuriser l'accès au panel d'administration et tracer les tentatives de connexion.
- Déployer automatiquement le site sur un VPS via la plateforme Coolify avec persistance des données.

---

## 3. ARCHITECTURE TECHNIQUE

L'application repose sur une architecture classique en 3 couches, exécutée dans un conteneur Docker.

- **Couche présentation (frontend)** : interface web réalisée en HTML5, CSS3 et JavaScript natif (ES6+). Pages publiques (`index.php`, `product.php`) et panel d'administration (`admin/`) générés côté serveur. Utilisation de SortableJS (via CDN) pour le glisser-déposer dans l'admin.
- **Couche traitement (backend)** : PHP 8.2 avec rendu serveur. Endpoints dédiés pour le formulaire de contact (`contact.php`), la réorganisation des produits (`admin/reorder.php`) et la suppression (`admin/delete.php`). Authentification gérée via sessions PHP avec régénération d'ID.
- **Couche persistance (données)** : base de données relationnelle SQLite 3, accédée via PDO avec requêtes préparées pour prévenir les injections SQL. Le fichier `data/products.db` est stocké dans un volume Docker persistant.

**Modèle relationnel principal** :

- **Produit** (id, slug, nom, image, descriptions, prix, badge, note, dimensions, matériau, contenu, actif, ordre).
- **Administrateur** (id, identifiant, hash du mot de passe).
- **Message** (id, nom, prénom, email, téléphone, sujet, message, IP, user-agent, lu).
- **TentativeConnexion** (id, IP, identifiant essayé, succès, date) pour le rate limit.
- **Paramètre** (clé, valeur) pour les textes éditables du site.

Toutes les tables sont autonomes (pas de FK explicite, SQLite n'imposant pas les contraintes par défaut).

---

## 4. FONCTIONNALITÉS PRINCIPALES

- **Authentification sécurisée** : connexion par identifiant + mot de passe hashé (`password_hash` bcrypt), sessions PHP avec régénération d'ID à la connexion, déconnexion explicite avec destruction de session.
- **Premier setup** : si aucun administrateur n'existe, redirection automatique vers une page de création de compte (`setup.php`) avec validation de la complexité du mot de passe.
- **Gestion des produits** : CRUD complet avec upload d'image (JPG/PNG/WEBP, max 5 Mo), génération automatique du slug à partir du nom, badges, notes, visibilité publique on/off, réorganisation par glisser-déposer (SortableJS).
- **Gestion des paramètres du site** : interface dédiée (`admin/settings.php`) permettant d'éditer 18 textes du site (titre, hero, collection, contact, footer) regroupés par section.
- **Formulaire de contact** : soumission AJAX avec validation côté serveur (email, longueurs min/max), honeypot anti-spam, stockage en base avec IP et user-agent.
- **Boîte de réception admin** : page `admin/messages.php` avec liste des messages, indicateur lu/non lu, badge de notification dans le menu, vue détaillée, suppression.
- **Catalogue dynamique** : la page d'accueil et les fiches produit lisent les données depuis la base SQLite, plus aucun contenu codé en dur.
- **Rate limit anti-brute-force** : limitation à 5 tentatives échouées en 15 minutes par IP avec désactivation temporaire du formulaire de connexion.

---

## 5. SÉCURITÉ MISE EN ŒUVRE

- **Protection contre l'injection SQL** : requêtes préparées PDO sur l'ensemble des accès à la base, paramètres nommés.
- **Protection CSRF** : génération et vérification de tokens CSRF sur tous les formulaires admin et sur le contact (`hash_equals`).
- **Protection XSS** : échappement systématique des sorties via `htmlspecialchars()` côté serveur, validation de types stricts (`(int)`, `(float)`).
- **Hachage des mots de passe** : `password_hash(PASSWORD_DEFAULT)` (bcrypt) à l'inscription et `password_verify()` à la connexion. Aucun stockage en clair.
- **Politique de mot de passe** : minimum 8 caractères imposé côté serveur.
- **Rate limiting** : 5 tentatives échouées par IP en 15 minutes, journalisation dans la table `login_attempts`, purge automatique à la connexion réussie.
- **Cookies de session** : flags `HttpOnly` et `SameSite` activés via la configuration PHP par défaut. Régénération de l'ID de session à chaque connexion réussie.
- **Honeypot anti-spam** : champ caché `website` sur le formulaire de contact ; toute soumission le remplissant est ignorée silencieusement.
- **Validation des uploads** : vérification du type MIME via `finfo`, restriction aux formats JPEG/PNG/WEBP, limite de taille 5 Mo, génération de noms aléatoires pour éviter les collisions.
- **Headers HTTP de sécurité** (via `.htaccess`) : `X-Content-Type-Options: nosniff`, `X-Frame-Options: SAMEORIGIN`, `Referrer-Policy: strict-origin-when-cross-origin`.
- **Blocage d'accès aux fichiers sensibles** : règles `RewriteRule` interdisant l'accès direct au dossier `/data/` (base SQLite) et aux fichiers cachés.

---

## 6. MÉTHODOLOGIE DE DÉVELOPPEMENT

- **Versionnement** : Git, dépôt hébergé sur GitHub (organisation Lyblics).
- **Conventions** : code PHP 8.2 typé strict, fonctions courtes et préfixées par domaine (`saveProduct`, `getMessages`, `recordLoginAttempt`).
- **Configuration externalisée** : aucun secret en dur dans le code ; les paramètres modifiables sont stockés dans la table `settings` ou injectés au build via Coolify (`COOLIFY_FQDN`, `COOLIFY_URL`).
- **Initialisation de la base** : automatique au premier accès via `initSchema()` et `seedIfEmpty()` dans `includes/db.php`. Aucune commande manuelle nécessaire.
- **Containerisation** : `Dockerfile` basé sur `php:8.2-apache`, installation de `pdo_sqlite` et `libsqlite3-dev`, activation de `mod_rewrite`, `mod_expires`, `mod_headers`. Permissions sur les dossiers `data/` et `images/uploads/` réglées au build.
- **Déploiement continu** : plateforme Coolify auto-hébergée sur VPS, mode Dockerfile activé, push GitHub déclenchant un redéploiement automatique. Deux volumes persistants configurés (`/var/www/html/data` et `/var/www/html/images/uploads`) pour préserver la base et les uploads entre deux déploiements.

---

## 7. PRODUCTIONS RÉALISÉES

- **Code source complet** :
  - Pages publiques : `index.php`, `product.php`, `contact.php`, `favicon.svg`.
  - Couche données : `includes/db.php` (PDO + helpers CRUD + seed initial).
  - Panel d'administration : `admin/auth.php`, `admin/login.php`, `admin/setup.php`, `admin/logout.php`, `admin/index.php`, `admin/edit.php`, `admin/delete.php`, `admin/messages.php`, `admin/reorder.php`, `admin/settings.php`.
- **Configuration de déploiement** : `Dockerfile`, `.dockerignore`, `.htaccess` (cache, headers de sécurité, blocage `/data/`), `.gitignore`.
- **Documentation technique** :
  - `README.md` (présentation, installation, déploiement Coolify).
  - `docs/DATA_DICTIONARY.md` (schéma technique des tables).
  - `docs/DICTIONNAIRE_DONNEES.md` (dictionnaire de données format Merise).
  - `docs/DOSSIER_PROJET.md` (présent document).
- **Outil utilitaire** : `extract_images.py` (script Python d'extraction des cristaux depuis les PDFs sources de l'atelier).

---

## 8. COMPÉTENCES MOBILISÉES

- **Concevoir et développer une solution applicative** :
  Analyse du besoin de Sophie (passage d'une vente informelle à un site vitrine maîtrisable), conception du modèle de données relationnel, choix d'une stack adaptée à un petit volume (SQLite plutôt que MySQL), développement complet du frontend et du backend, refonte progressive du code initial pour retirer la couche e-commerce inutile.
- **Assurer la maintenance corrective ou évolutive d'une solution applicative** :
  Mise en place d'un système d'auto-migration via `initSchema()`, ajout de fonctionnalités successives (rate limit, honeypot, drag-and-drop, settings éditables), gestion des bugs de déploiement (permissions Docker, extension `pdo_sqlite` manquante, headers SQLite), refactorisation des textes hardcodés vers une table `settings`.
- **Gérer les données** :
  Modélisation relationnelle (5 tables, dictionnaire de données complet), écriture de requêtes SQL préparées, mise en place d'un index sur la table `login_attempts`, gestion des intégrités via contraintes `UNIQUE` et validations applicatives, sécurisation des accès (PDO, requêtes préparées, échappement).

---

## 9. BILAN

Ce projet m'a permis de mettre en pratique l'ensemble des compétences du bloc 2 du BTS SIO option SLAM dans un contexte réaliste de développement d'application web pour un client réel. Il a également été l'occasion d'approfondir la sécurisation d'une application web (CSRF, XSS, brute-force, honeypot, headers HTTP), la containerisation Docker et le déploiement continu sur une plateforme PaaS auto-hébergée (Coolify). L'autonomie laissée à l'administratrice grâce au panel de gestion (produits + textes + messages) est un point fort retenu par la cliente : aucune intervention de développement n'est nécessaire pour faire évoluer le contenu du site. L'application est aujourd'hui accessible en ligne ([https://noel.lyblics.com/](https://noel.lyblics.com/)) et continue d'évoluer en fonction des retours utilisateurs.
