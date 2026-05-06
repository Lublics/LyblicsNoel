# Dictionnaire de données — LyblicsNoel

**Projet** : Site vitrine "Noël de Sophie"
**SGBD** : SQLite 3
**Fichier** : `data/products.db` (créé et seedé automatiquement au premier accès via `includes/db.php`)
**Encodage** : UTF-8

---

## Vue d'ensemble

| Table | Rôle | Volume estimé |
|---|---|---|
| `products` | Catalogue des produits visibles sur le site | ~10–50 lignes |
| `admins` | Comptes administrateurs du panel | 1–3 lignes |
| `messages` | Messages reçus via le formulaire de contact | croissant |
| `login_attempts` | Journal des tentatives de connexion (rate limit) | rotatif |
| `settings` | Paramètres éditables du site (textes, contact, etc.) | ~20 lignes |

---

## Table : `products`

Catalogue des produits affichés sur le site public et gérés depuis l'admin.

| Colonne | Type | NULL | Défaut | Clé | Description |
|---|---|---|---|---|---|
| `id` | INTEGER | NON | AUTOINCREMENT | **PK** | Identifiant unique interne |
| `slug` | TEXT | NON | — | **UNIQUE** | Identifiant URL (ex: `cristal-01`). Lettres / chiffres / tirets uniquement |
| `name` | TEXT | NON | — | — | Nom commercial du produit |
| `image` | TEXT | OUI | — | — | Chemin relatif vers le visuel (ex: `images/cristal_01.png` ou `images/uploads/...`) |
| `description_courte` | TEXT | OUI | — | — | Texte affiché sur la carte de la collection |
| `description_longue` | TEXT | OUI | — | — | Texte affiché sur la fiche produit complète |
| `prix` | REAL | NON | `0` | — | Prix en EUR (TTC) |
| `badge` | TEXT | OUI | — | — | Étiquette optionnelle : `NOUVEAUTE`, `BEST-SELLER`, `EDITION LIMITEE`, etc. |
| `rating` | INTEGER | NON | `5` | CHECK 0–5 | Note sur 5 étoiles |
| `dimensions` | TEXT | OUI | — | — | Caractéristique : dimensions du produit |
| `materiau` | TEXT | OUI | — | — | Caractéristique : matériau |
| `inclus` | TEXT | OUI | — | — | Caractéristique : contenu de la livraison |
| `actif` | INTEGER | NON | `1` | — | Visibilité : `1` = visible publiquement, `0` = caché |
| `ordre` | INTEGER | NON | `0` | — | Ordre d'affichage (croissant). Modifié par drag-and-drop dans l'admin |
| `created_at` | TEXT | OUI | `CURRENT_TIMESTAMP` | — | Date de création (ISO 8601) |
| `updated_at` | TEXT | OUI | `CURRENT_TIMESTAMP` | — | Date de dernière modification (mise à jour par `saveProduct()`) |

**Règles métier**
- `slug` doit être unique. Le code de l'admin convertit automatiquement le nom en slug via `slugify()`.
- Les produits inactifs (`actif = 0`) sont filtrés de la liste publique mais conservés en base.
- Les images uploadées via l'admin atterrissent dans `images/uploads/` (volume persistant).

---

## Table : `admins`

Comptes administrateurs autorisés à se connecter au panel `/admin/`.

| Colonne | Type | NULL | Défaut | Clé | Description |
|---|---|---|---|---|---|
| `id` | INTEGER | NON | AUTOINCREMENT | **PK** | Identifiant interne |
| `username` | TEXT | NON | — | **UNIQUE** | Identifiant de connexion (min. 3 caractères) |
| `password_hash` | TEXT | NON | — | — | Hash bcrypt du mot de passe (généré via `password_hash(PASSWORD_DEFAULT)`) |
| `created_at` | TEXT | OUI | `CURRENT_TIMESTAMP` | — | Date de création du compte |

**Règles métier**
- Si la table est vide, l'accès à `/admin/` redirige vers `setup.php` pour créer le 1er admin.
- Mot de passe : 8 caractères minimum (validé côté serveur).
- Aucun mot de passe stocké en clair — uniquement le hash bcrypt.

---

## Table : `messages`

Messages reçus depuis le formulaire de contact public (`contact.php`).

| Colonne | Type | NULL | Défaut | Clé | Description |
|---|---|---|---|---|---|
| `id` | INTEGER | NON | AUTOINCREMENT | **PK** | Identifiant interne |
| `nom` | TEXT | NON | — | — | Nom du visiteur (max 100 car) |
| `prenom` | TEXT | NON | — | — | Prénom du visiteur (max 100 car) |
| `email` | TEXT | NON | — | — | Email validé via `FILTER_VALIDATE_EMAIL` |
| `telephone` | TEXT | OUI | — | — | Téléphone optionnel (max 30 car) |
| `sujet` | TEXT | NON | — | — | Sujet sélectionné dans le formulaire |
| `message` | TEXT | NON | — | — | Corps du message (5 à 5000 caractères) |
| `ip` | TEXT | OUI | — | — | IP du visiteur (utile pour bloquer du spam) |
| `user_agent` | TEXT | OUI | — | — | User-Agent du navigateur (tronqué à 500 car) |
| `lu` | INTEGER | NON | `0` | — | `0` = non lu, `1` = lu |
| `created_at` | TEXT | OUI | `CURRENT_TIMESTAMP` | — | Date de réception |

**Règles métier**
- Honeypot anti-spam : si le champ caché `website` est rempli, le message n'est jamais sauvegardé.
- Le statut `lu` passe à `1` automatiquement à l'ouverture du message dans `/admin/messages.php`.
- Suppression définitive via `deleteMessage($id)` (pas de soft-delete).

---

## Table : `login_attempts`

Journal des tentatives de connexion à l'admin pour le rate limit (5 échecs / 15 min / IP).

| Colonne | Type | NULL | Défaut | Clé | Description |
|---|---|---|---|---|---|
| `id` | INTEGER | NON | AUTOINCREMENT | **PK** | Identifiant interne |
| `ip` | TEXT | NON | — | INDEX | IP source de la tentative |
| `username` | TEXT | OUI | — | — | Identifiant essayé (utile pour analyser les attaques) |
| `success` | INTEGER | NON | `0` | — | `1` = connexion réussie, `0` = échec |
| `attempted_at` | TEXT | OUI | `CURRENT_TIMESTAMP` | INDEX | Horodatage de la tentative |

**Index**
- `idx_attempts_ip` sur `(ip, attempted_at)` — accélère le compteur sur fenêtre glissante.

**Règles métier**
- `recentFailedAttempts($ip, 15)` compte les échecs des 15 dernières minutes pour cette IP.
- Au-delà de 5 échecs, le formulaire de login est désactivé.
- À la connexion réussie, `clearLoginAttempts($ip)` purge les échecs de l'IP.
- ⚠️ **Pas de purge automatique** des entrées anciennes — à prévoir si la table grossit beaucoup (cron / job).

---

## Table : `settings`

Paramètres du site éditables depuis `/admin/settings.php`.

| Colonne | Type | NULL | Défaut | Clé | Description |
|---|---|---|---|---|---|
| `key` | TEXT | NON | — | **PK** | Identifiant logique du paramètre |
| `value` | TEXT | NON | `''` | — | Valeur du paramètre |
| `updated_at` | TEXT | OUI | `CURRENT_TIMESTAMP` | — | Date de dernière modification |

**Clés gérées (seedées automatiquement)**

| Clé | Type d'édition | Utilisation |
|---|---|---|
| `site_title` | text | Titre de l'onglet navigateur |
| `logo_text` | text | Texte du logo en en-tête + footer |
| `announcement` | text (HTML autorisé) | Bandeau d'annonce en haut de page |
| `hero_title` | text | Titre principal de la page d'accueil |
| `hero_subtitle` | textarea | Sous-titre du hero |
| `hero_cta` | text | Texte du bouton "Découvrir la collection" |
| `collection_title` | text | Titre de la section collection |
| `collection_subtitle` | text | Sous-titre |
| `collection_description` | textarea | Encadré descriptif au-dessus de la grille produits |
| `contact_title` | text | Titre de la section contact |
| `contact_subtitle` | text | Sous-titre |
| `contact_intro` | textarea | Paragraphe d'introduction des coordonnées |
| `contact_phone` | text | Téléphone affiché |
| `contact_email` | email | Email affiché |
| `contact_address` | textarea | Adresse postale (sauts de ligne autorisés) |
| `contact_hours` | textarea | Horaires (sauts de ligne autorisés) |
| `footer_about` | textarea | Texte "À propos" du pied de page |
| `footer_copyright` | text | Mention de copyright (la date est ajoutée dynamiquement) |

**Règles métier**
- Lecture : `getSetting('clé', 'valeur par défaut')` ou `getSettings()` (tableau complet).
- Écriture : `saveSettings(['clé' => 'valeur', ...])` (UPSERT).
- Au seed initial, `INSERT OR IGNORE` garantit qu'une clé existante ne sera jamais écrasée.

---

## Relations entre tables

SQLite n'impose pas les contraintes FK par défaut ; le schéma actuel n'utilise pas de relation explicite. Les tables sont **indépendantes** :

```
products       (autonome — catalogue)
admins         (autonome — auth)
messages       (autonome — flux entrant)
login_attempts (lien logique vers admins.username, mais pas FK)
settings       (autonome — config)
```

Aucune jointure n'est nécessaire dans l'application actuelle.

---

## Indexes

| Index | Table | Colonnes | Usage |
|---|---|---|---|
| `sqlite_autoindex_products_1` | `products` | `slug` | Implicite via UNIQUE |
| `sqlite_autoindex_admins_1` | `admins` | `username` | Implicite via UNIQUE |
| `idx_attempts_ip` | `login_attempts` | `(ip, attempted_at)` | Comptage des échecs récents |

---

## Conventions communes

- **Dates** : stockées en `TEXT` au format SQLite ISO 8601 (`YYYY-MM-DD HH:MM:SS`), via `CURRENT_TIMESTAMP`.
- **Booléens** : stockés en `INTEGER` (`0` / `1`), SQLite n'ayant pas de type boolean natif.
- **Chemins d'images** : toujours **relatifs** à la racine du site (ex: `images/cristal_01.png`), pas absolus.
- **Hashs de mots de passe** : `PASSWORD_DEFAULT` (bcrypt côté PHP 8.x). Migration future automatique si l'algo par défaut change.

---

## Cycle de vie de la base

1. **Premier accès** au site : `db()` crée `data/products.db` si absent, applique `initSchema()`, puis `seedIfEmpty()` insère 10 produits + `seedSettingsIfMissing()` insère les paramètres par défaut.
2. **Premier accès admin** : si `admins` est vide → redirection vers `/admin/setup.php` pour créer le compte.
3. **Persistance** : sur déploiement Coolify, `data/` doit être un volume persistant (sinon perte de données à chaque redéploiement).

---

## Couche d'accès aux données (PHP)

Toutes les opérations passent par les helpers de `includes/db.php` :

| Fonction | Rôle |
|---|---|
| `db()` | PDO singleton, init schéma + seed |
| `getProducts(bool $onlyActive = true)` | Liste les produits (filtre `actif`) |
| `getProduct(string $slug)` / `getProductById(int $id)` | Récupère 1 produit |
| `saveProduct(array $data, ?int $id)` | Crée ou met à jour |
| `deleteProduct(int $id)` | Suppression définitive |
| `reorderProducts(array $ids)` | Met à jour `ordre` en transaction |
| `findAdmin(string $username)` / `createAdmin()` / `adminCount()` | Gestion admin |
| `saveMessage()` / `getMessages()` / `markMessageRead()` / `deleteMessage()` | Messages |
| `recordLoginAttempt()` / `recentFailedAttempts()` / `clearLoginAttempts()` | Rate limit |
| `getSettings()` / `getSetting()` / `saveSettings()` | Paramètres |
| `clientIp()` | Helper IP (gère `X-Forwarded-For` derrière reverse proxy) |
