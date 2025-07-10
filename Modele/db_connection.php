<?php
// Chargement automatique des dépendances via Composer
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Chargement des variables d'environnement depuis le fichier .env s'il est présent
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad(); // safeLoad permet de ne pas générer d'erreur si le fichier .env est absent (ex. en prod)

// --- Connexion locale ou distante (Heroku / JawsDB) ---

// Si l'application est déployée sur Heroku, la variable JAWSDB_URL est définie
$jawsdb_url = getenv('JAWSDB_URL') ?: $_ENV['JAWSDB_URL'] ?? null;

if ($jawsdb_url) {
    // Parsing de l'URL JAWSDB en composantes (hôte, utilisateur, mot de passe...)
    $url = parse_url($jawsdb_url);
    $host = $url['host'];
    $port = $url['port'] ?? 3306;
    $dbname = ltrim($url['path'], '/');
    $username = $url['user'];
    $password = $url['pass'];
} else {
    // Sinon, on récupère les valeurs définies dans le .env
    $host = $_ENV['DB_HOST'] ?? 'localhost';
    $port = $_ENV['DB_PORT'] ?? '3306';
    $dbname = $_ENV['DB_NAME'] ?? 'memory';
    $username = $_ENV['DB_USER'] ?? 'root';
    $password = $_ENV['DB_PASS'] ?? '';
}

// --- Connexion à la base de données avec PDO ---
try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,       // Remonte les erreurs SQL
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC   // Récupère les résultats sous forme associative
        ]
    );
} catch (PDOException $e) {
    // En cas d'erreur, afficher un message clair (à éviter en production)
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
