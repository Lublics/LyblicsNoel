<?php
/**
 * Couche d'accès aux données (SQLite via PDO).
 * Initialise la base et propose les helpers CRUD pour produits + admins.
 */

const DB_PATH = __DIR__ . '/../data/products.db';

function db(): PDO {
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    $dir = dirname(DB_PATH);
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }

    $pdo = new PDO('sqlite:' . DB_PATH);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec('PRAGMA foreign_keys = ON');

    initSchema($pdo);
    seedIfEmpty($pdo);

    return $pdo;
}

function initSchema(PDO $pdo): void {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS products (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            slug TEXT UNIQUE NOT NULL,
            name TEXT NOT NULL,
            image TEXT,
            description_courte TEXT,
            description_longue TEXT,
            prix REAL NOT NULL DEFAULT 0,
            badge TEXT,
            rating INTEGER NOT NULL DEFAULT 5,
            dimensions TEXT,
            materiau TEXT,
            inclus TEXT,
            actif INTEGER NOT NULL DEFAULT 1,
            ordre INTEGER NOT NULL DEFAULT 0,
            created_at TEXT DEFAULT CURRENT_TIMESTAMP,
            updated_at TEXT DEFAULT CURRENT_TIMESTAMP
        )
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS admins (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            password_hash TEXT NOT NULL,
            created_at TEXT DEFAULT CURRENT_TIMESTAMP
        )
    ");
}

function seedIfEmpty(PDO $pdo): void {
    $count = (int) $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
    if ($count > 0) {
        return;
    }

    $seed = [
        ['cristal-01', 'Boule Cristal Vajrapani', 'images/cristal_01.png',
         'Boule en cristal avec gravure laser 3D representant le gardien protecteur. Socle bois lumineux LED. Diametre 8cm.',
         'Decouvrez cette magnifique boule en cristal ornee d\'une gravure laser 3D representant Vajrapani, le gardien protecteur dans la tradition bouddhiste. Cette piece d\'exception est realisee avec un cristal de haute qualite qui capture et reflete la lumiere de maniere spectaculaire. Livree avec un elegant socle en bois naturel equipe d\'un eclairage LED qui illumine la gravure et cree une ambiance feerique. Parfait comme decoration ou comme cadeau spirituel.',
         45, 'NOUVEAUTE', 5],
        ['cristal-03', 'Boule Cristal Chenrezig', 'images/cristal_03.png',
         'Bodhisattva de la compassion avec aureole elaboree, grave au laser 3D. Socle bois lumineux LED. Diametre 8cm.',
         'Chenrezig, le bodhisattva de la compassion, est represente ici avec son aureole elaboree symbolisant l\'illumination spirituelle. Cette gravure laser 3D capture chaque detail de cette divinite venerable dans le bouddhisme tibetain. Une piece contemplative ideale pour la meditation ou comme element decoratif spirituel. Le socle en bois avec LED integree met en valeur les details subtils de la gravure.',
         42, '', 5],
        ['cristal-07', 'Boule Cristal Guanyin', 'images/cristal_07.png',
         'Deesse de la misericorde tenant une fleur de lotus, gravure laser 3D. Symbole de compassion. Diametre 8cm.',
         'Guanyin, la deesse de la misericorde et de la compassion, est representee ici tenant delicatement une fleur de lotus, symbole de purete spirituelle. Cette gravure laser 3D d\'une finesse exceptionnelle capture toute la serenite et la bienveillance de cette divinite venerable en Asie. Une piece maitresse pour ceux qui recherchent paix interieure et protection spirituelle. L\'eclairage LED du socle revele chaque detail de cette oeuvre.',
         52, 'BEST-SELLER', 5],
        ['cristal-12', 'Boule Cristal Samantabhadra', 'images/cristal_12.png',
         'Bodhisattva de la pratique sur son elephant blanc, gravure laser 3D. Piece spirituelle. Diametre 8cm.',
         'Samantabhadra, le bodhisattva de la pratique et de la meditation, est represente majestueusement monte sur son elephant blanc, symbole de force et de sagesse. Cette gravure laser 3D capture la grace et la puissance de cette scene mythique du bouddhisme. Une piece spirituelle parfaite pour creer un espace de calme et d\'inspiration dans votre interieur.',
         39, '', 4],
        ['cristal-14', 'Boule Cristal Avalokiteshvara', 'images/cristal_14.png',
         'Divinite aux mille bras, symbole de compassion universelle. Gravure laser 3D exceptionnelle. Diametre 8cm.',
         'Avalokiteshvara aux mille bras est l\'une des representations les plus impressionnantes du bouddhisme. Chaque bras symbolise la capacite infinie du bodhisattva a aider tous les etres souffrants. Cette gravure laser 3D d\'une complexite exceptionnelle capture chaque detail de cette divinite venerable. Une piece de collection pour les connaisseurs d\'art spirituel asiatique.',
         68, 'EDITION LIMITEE', 5],
        ['cristal-15', 'Boule Cristal Mille Bras', 'images/cristal_15.png',
         'Avalokiteshvara debout aux mille bras protecteurs. Chef-d\'oeuvre de gravure laser 3D. Diametre 8cm.',
         'Cette representation d\'Avalokiteshvara debout avec ses mille bras protecteurs est un chef-d\'oeuvre de gravure laser 3D. Chaque bras tient un symbole ou un outil destine a aider les etres souffrants. La posture debout confere a cette piece une presence majestueuse. Ideal pour creer une atmosphere de serenite et de protection spirituelle dans votre interieur.',
         58, '', 5],
        ['cristal-17', 'Boule Cristal Tara Verte', 'images/cristal_17.png',
         'Bodhisattva feminin de la compassion active avec aureole rayonnante. Gravure laser 3D. Diametre 8cm.',
         'Tara Verte est le bodhisattva feminin de la compassion active dans le bouddhisme tibetain. Elle est representee ici avec son aureole rayonnante, prete a venir en aide a tous ceux qui l\'invoquent. Cette gravure laser 3D capture la grace et la bienveillance de cette divinite protectrice. Une piece ideale pour ceux qui recherchent protection et guidance spirituelle.',
         44, 'NOUVEAUTE', 5],
        ['cristal-19', 'Boule Cristal Manjushri', 'images/cristal_19.png',
         'Bodhisattva de la sagesse avec couronne et aureole. Gravure laser 3D detaillee. Diametre 8cm.',
         'Manjushri est le bodhisattva de la sagesse transcendante dans le bouddhisme. Il est represente ici avec sa couronne et son aureole rayonnante, symbolisant l\'illumination spirituelle. Cette gravure laser 3D capture chaque detail de cette divinite associee a l\'intelligence et a la connaissance. Une piece ideale pour les etudiants, les chercheurs et tous ceux qui valorisent la sagesse.',
         44, '', 4],
        ['cristal-23', 'Boule Cristal Ballerine Classique', 'images/cristal_23.png',
         'Elegante danseuse classique bras leves, gravee au laser 3D. Cadeau ideal pour passionnes de danse. Diametre 8cm.',
         'Cette elegante ballerine classique est representee bras leves dans une pose gracieuse et intemporelle. La gravure laser 3D capture chaque detail de son tutu et de sa posture elegante. Cette piece ravira les passionnes de danse classique, les jeunes danseuses et tous ceux qui apprecient la beaute du ballet. L\'eclairage LED du socle cree un effet feerique qui magnifie la silhouette de la danseuse.',
         48, 'BEST-SELLER', 5],
        ['cristal-24', 'Boule Cristal Danseuse Etoile', 'images/cristal_24.png',
         'Danseuse etoile en tutu, chef-d\'oeuvre de gravure laser 3D. Socle bois naturel avec LED. Diametre 8cm.',
         'Cette danseuse etoile en tutu classique incarne l\'excellence et la grace du ballet. Gravee avec une precision exceptionnelle au laser 3D, elle semble executer un mouvement aerien au coeur du cristal. Le cristal de premiere qualite capture chaque nuance de cette pose iconique. Une piece d\'exception qui fera un cadeau memorable pour toute occasion speciale.',
         46, '', 5],
    ];

    $stmt = $pdo->prepare("
        INSERT INTO products (slug, name, image, description_courte, description_longue, prix, badge, rating, dimensions, materiau, inclus, ordre)
        VALUES (:slug, :name, :image, :desc_c, :desc_l, :prix, :badge, :rating, :dim, :mat, :inc, :ordre)
    ");

    $ordre = 0;
    foreach ($seed as $row) {
        $stmt->execute([
            ':slug'   => $row[0],
            ':name'   => $row[1],
            ':image'  => $row[2],
            ':desc_c' => $row[3],
            ':desc_l' => $row[4],
            ':prix'   => $row[5],
            ':badge'  => $row[6],
            ':rating' => $row[7],
            ':dim'    => 'Diametre: 8cm',
            ':mat'    => 'Cristal K9 haute qualite',
            ':inc'    => 'Boule cristal + Socle bois LED + Cable USB',
            ':ordre'  => $ordre++,
        ]);
    }
}

function getProducts(bool $onlyActive = true): array {
    $sql = 'SELECT * FROM products';
    if ($onlyActive) {
        $sql .= ' WHERE actif = 1';
    }
    $sql .= ' ORDER BY ordre ASC, id ASC';
    return db()->query($sql)->fetchAll();
}

function getProduct(string $slug): ?array {
    $stmt = db()->prepare('SELECT * FROM products WHERE slug = :slug LIMIT 1');
    $stmt->execute([':slug' => $slug]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function getProductById(int $id): ?array {
    $stmt = db()->prepare('SELECT * FROM products WHERE id = :id LIMIT 1');
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function saveProduct(array $data, ?int $id = null): int {
    $fields = [
        'slug', 'name', 'image', 'description_courte', 'description_longue',
        'prix', 'badge', 'rating', 'dimensions', 'materiau', 'inclus', 'actif', 'ordre',
    ];

    $payload = [];
    foreach ($fields as $f) {
        $payload[':' . $f] = $data[$f] ?? null;
    }

    if ($id === null) {
        $sql = 'INSERT INTO products (' . implode(',', $fields) . ') VALUES (' .
               implode(',', array_map(fn($f) => ':' . $f, $fields)) . ')';
        $stmt = db()->prepare($sql);
        $stmt->execute($payload);
        return (int) db()->lastInsertId();
    }

    $set = implode(', ', array_map(fn($f) => "$f = :$f", $fields));
    $sql = "UPDATE products SET $set, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
    $stmt = db()->prepare($sql);
    $payload[':id'] = $id;
    $stmt->execute($payload);
    return $id;
}

function deleteProduct(int $id): void {
    $stmt = db()->prepare('DELETE FROM products WHERE id = :id');
    $stmt->execute([':id' => $id]);
}

function adminCount(): int {
    return (int) db()->query('SELECT COUNT(*) FROM admins')->fetchColumn();
}

function findAdmin(string $username): ?array {
    $stmt = db()->prepare('SELECT * FROM admins WHERE username = :u LIMIT 1');
    $stmt->execute([':u' => $username]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function createAdmin(string $username, string $password): void {
    $stmt = db()->prepare('INSERT INTO admins (username, password_hash) VALUES (:u, :h)');
    $stmt->execute([
        ':u' => $username,
        ':h' => password_hash($password, PASSWORD_DEFAULT),
    ]);
}
