# Dictionnaire de données — LyblicsNoel

**Projet** : Site vitrine "Noël de Sophie"
**Méthode** : Merise — liste à plat des propriétés du système d'information
**Date** : 2026-05-06

## Légende des codes

**Type**
- `AN` : alphanumérique (chaîne de caractères)
- `N` : numérique entier
- `D` : décimal (réel)
- `DT` : date / horodatage (ISO 8601)
- `B` : booléen (stocké en 0/1)

**Nature**
- `E` : élémentaire (saisie ou stockée telle quelle)
- `C` : calculée (déduite par formule ou requête)
- `CC` : concaténée (composée de plusieurs propriétés)

**Contraintes**
- `PK` : clé primaire
- `UQ` : unique
- `NN` : non nul (obligatoire)
- `FK` : clé étrangère (logique, non imposée par SQLite)

---

## 1. Données élémentaires (stockées en base)

### 1.1 Domaine : Produit

| Code | Désignation | Type | Taille | Nature | Contraintes | Règles / Observations |
|---|---|---|---|---|---|---|
| `id_produit` | Identifiant interne du produit | N | — | E | PK, NN, AUTO | Auto-incrémenté par SQLite |
| `slug_produit` | Identifiant URL du produit | AN | 50 | E | UQ, NN | Format : `[a-z0-9-]+` (généré par `slugify()`) |
| `nom_produit` | Nom commercial | AN | 200 | E | NN | Ex : "Boule Cristal Vajrapani" |
| `image_produit` | Chemin du visuel | AN | 255 | E | — | Chemin relatif (ex : `images/cristal_01.png`) |
| `description_courte_produit` | Description carte collection | AN | 500 | E | — | Affichée sur la grille publique |
| `description_longue_produit` | Description fiche complète | AN | 5000 | E | — | Affichée sur la page détail |
| `prix_produit` | Prix de vente | D | 10,2 | E | NN, ≥ 0 | En euros TTC |
| `badge_produit` | Étiquette commerciale | AN | 50 | E | — | Valeurs usuelles : "NOUVEAUTE", "BEST-SELLER", "EDITION LIMITEE" |
| `note_produit` | Note d'évaluation | N | 1 | E | NN, [0–5] | Affichée en étoiles |
| `dimensions_produit` | Caractéristique : dimensions | AN | 100 | E | — | Ex : "Diamètre : 8 cm" |
| `materiau_produit` | Caractéristique : matériau | AN | 100 | E | — | Ex : "Cristal K9 haute qualité" |
| `inclus_produit` | Caractéristique : contenu livraison | AN | 200 | E | — | Ex : "Boule + socle + câble USB" |
| `actif_produit` | Indicateur de visibilité | B | 1 | E | NN | 1 = visible publiquement, 0 = masqué |
| `ordre_produit` | Position d'affichage | N | — | E | NN | Croissant ; modifié par drag-and-drop |
| `date_creation_produit` | Date de création | DT | — | E | — | Auto : `CURRENT_TIMESTAMP` |
| `date_maj_produit` | Date de dernière modification | DT | — | E | — | Mise à jour à chaque `saveProduct()` |

### 1.2 Domaine : Administrateur

| Code | Désignation | Type | Taille | Nature | Contraintes | Règles / Observations |
|---|---|---|---|---|---|---|
| `id_admin` | Identifiant interne admin | N | — | E | PK, NN, AUTO | — |
| `nom_utilisateur_admin` | Identifiant de connexion | AN | 50 | E | UQ, NN | Min. 3 caractères |
| `mot_de_passe_admin` | Hash du mot de passe | AN | 255 | E | NN | Algorithme bcrypt (`password_hash` PHP) ; jamais stocké en clair |
| `date_creation_admin` | Date de création du compte | DT | — | E | — | Auto |

### 1.3 Domaine : Message de contact

| Code | Désignation | Type | Taille | Nature | Contraintes | Règles / Observations |
|---|---|---|---|---|---|---|
| `id_message` | Identifiant interne du message | N | — | E | PK, NN, AUTO | — |
| `nom_visiteur` | Nom du visiteur | AN | 100 | E | NN | Saisi sur formulaire public |
| `prenom_visiteur` | Prénom du visiteur | AN | 100 | E | NN | Saisi sur formulaire public |
| `email_visiteur` | Adresse email du visiteur | AN | 254 | E | NN | Validé par `FILTER_VALIDATE_EMAIL` |
| `telephone_visiteur` | Téléphone du visiteur | AN | 30 | E | — | Optionnel |
| `sujet_message` | Sujet du message | AN | 100 | E | NN | Sélection : "information", "personnalisation", "autre" |
| `corps_message` | Contenu du message | AN | 5000 | E | NN | Min. 5 / max. 5000 caractères |
| `ip_visiteur` | IP source du visiteur | AN | 45 | E | — | Format IPv4 ou IPv6 ; utile pour blocage spam |
| `user_agent_visiteur` | User-Agent du navigateur | AN | 500 | E | — | Tronqué à 500 caractères |
| `lu_message` | Indicateur de lecture | B | 1 | E | NN | 0 = non lu, 1 = lu (passé à 1 à l'ouverture admin) |
| `date_reception_message` | Date de réception | DT | — | E | — | Auto : `CURRENT_TIMESTAMP` |

### 1.4 Domaine : Tentative de connexion (rate limit)

| Code | Désignation | Type | Taille | Nature | Contraintes | Règles / Observations |
|---|---|---|---|---|---|---|
| `id_tentative` | Identifiant interne de la tentative | N | — | E | PK, NN, AUTO | — |
| `ip_tentative` | IP source de la tentative | AN | 45 | E | NN | Indexé pour comptage rapide |
| `nom_utilisateur_tentative` | Identifiant essayé | AN | 50 | E | — | Référence logique vers `nom_utilisateur_admin` (FK non imposée) |
| `succes_tentative` | Résultat de la tentative | B | 1 | E | NN | 0 = échec, 1 = succès |
| `date_tentative` | Horodatage de la tentative | DT | — | E | — | Indexé avec `ip_tentative` |

### 1.5 Domaine : Paramètre de site

| Code | Désignation | Type | Taille | Nature | Contraintes | Règles / Observations |
|---|---|---|---|---|---|---|
| `cle_parametre` | Identifiant logique du paramètre | AN | 50 | E | PK, NN | Ex : `hero_title`, `contact_phone` |
| `valeur_parametre` | Valeur du paramètre | AN | 5000 | E | NN | Texte ou HTML selon le paramètre |
| `date_maj_parametre` | Date de dernière modification | DT | — | E | — | Auto via `saveSettings()` |

#### Liste des clés gérées

| Clé | Domaine fonctionnel | Format d'édition |
|---|---|---|
| `site_title` | Général | texte court |
| `logo_text` | Général | texte court |
| `announcement` | Général | texte (HTML autorisé) |
| `hero_title` | Hero | texte court |
| `hero_subtitle` | Hero | texte long |
| `hero_cta` | Hero | texte court |
| `collection_title` | Collection | texte court |
| `collection_subtitle` | Collection | texte court |
| `collection_description` | Collection | texte long |
| `contact_title` | Contact | texte court |
| `contact_subtitle` | Contact | texte court |
| `contact_intro` | Contact | texte long |
| `contact_phone` | Contact | texte court |
| `contact_email` | Contact | email |
| `contact_address` | Contact | texte long (multi-ligne) |
| `contact_hours` | Contact | texte long (multi-ligne) |
| `footer_about` | Pied de page | texte long |
| `footer_copyright` | Pied de page | texte court |

---

## 2. Données calculées et dérivées (non stockées)

| Code | Désignation | Type | Nature | Règle de calcul | Source |
|---|---|---|---|---|---|
| `nb_produits_total` | Nombre total de produits | N | C | `COUNT(*) FROM products` | Dashboard admin |
| `nb_messages_non_lus` | Nombre de messages non lus | N | C | `COUNT(*) FROM messages WHERE lu_message = 0` | Badge menu admin |
| `nb_tentatives_recentes` | Tentatives échouées récentes par IP | N | C | `COUNT(*) FROM login_attempts WHERE ip = ? AND succes = 0 AND date >= now - 15 min` | Rate limit login |
| `est_bloque` | IP bloquée pour login | B | C | `nb_tentatives_recentes >= 5` | Login admin |
| `prix_produit_formate` | Prix formaté pour affichage | AN | C | `number_format(prix_produit, 2, ',', ' ') . ' EUR'` | Affichage public |
| `etoiles_produit` | Représentation HTML des étoiles | AN | C | Boucle 1→5 : ★ si i ≤ note, sinon ☆ | Cartes produit + fiche |
| `nom_complet_visiteur` | Nom + prénom du visiteur | AN | CC | `prenom_visiteur \|\| ' ' \|\| nom_visiteur` | Liste messages admin |
| `annee_courante` | Année du copyright | N | C | `date('Y')` PHP | Pied de page |
| `slug_genere` | Slug généré depuis le nom | AN | C | Minuscules + retrait accents + remplacement non-alphanum par `-` | Aide saisie admin |

---

## 3. Données issues du contexte (non stockées)

Données provenant de la requête HTTP, conservées temporairement ou loguées.

| Code | Désignation | Source | Usage |
|---|---|---|---|
| `csrf_token` | Jeton anti-CSRF | Session PHP | Protection des formulaires admin et public |
| `session_admin_id` | ID de l'admin connecté | Session PHP | Vérification d'authentification |
| `session_admin_username` | Identifiant de l'admin connecté | Session PHP | Affichage interface admin |
| `flash_message` | Message éphémère (succès / erreur) | Session PHP | Confirmation d'action (création, suppression…) |
| `honeypot_website` | Champ caché anti-bot | POST formulaire | Si rempli → message ignoré silencieusement |

---

## 4. Règles d'intégrité et contraintes globales

| Règle | Description |
|---|---|
| **R1** | `slug_produit` doit être unique parmi tous les produits |
| **R2** | `nom_utilisateur_admin` doit être unique parmi tous les admins |
| **R3** | `note_produit` ∈ [0, 5] |
| **R4** | `prix_produit` ≥ 0 |
| **R5** | Un produit avec `actif_produit = 0` n'est jamais affiché publiquement |
| **R6** | Un message vide (`corps_message` < 5 car) ne peut pas être enregistré |
| **R7** | Un visiteur dépassant 5 tentatives échouées en 15 min est bloqué |
| **R8** | `mot_de_passe_admin` ≥ 8 caractères en saisie ; stocké uniquement en hash bcrypt |
| **R9** | Toute image uploadée est de type `image/jpeg`, `image/png` ou `image/webp`, taille ≤ 5 Mo |
| **R10** | Les chemins d'image sont **relatifs** à la racine du site (jamais absolus) |

---

## 5. Récapitulatif

| Domaine | Nombre de propriétés élémentaires | Identifiant |
|---|---|---|
| Produit | 16 | `id_produit` |
| Administrateur | 4 | `id_admin` |
| Message de contact | 11 | `id_message` |
| Tentative de connexion | 5 | `id_tentative` |
| Paramètre de site | 3 | `cle_parametre` |
| **Total** | **39 propriétés élémentaires** | |
