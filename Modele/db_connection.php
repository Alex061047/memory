<?php
// Chargement des dépendances via Composer
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Chargement des variables d'environnement (.env)
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad(); 

// Récupère les valeurs définies dans le .env
    $host = $_ENV['DB_HOST'] ?? 'localhost';
    $port = $_ENV['DB_PORT'] ?? '3306';
    $dbname = $_ENV['DB_NAME'] ?? 'memory';
    $username = $_ENV['DB_USER'] ?? 'root';
    $password = $_ENV['DB_PASS'] ?? '';


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
    // En cas d'erreur, afficher un message clair
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
