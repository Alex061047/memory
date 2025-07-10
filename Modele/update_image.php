<?php
// Démarre la session PHP
session_start();

//Vérifie que l'utilisateur est l'administrateur
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Accès refusé']);
    exit;
}

// Charge la connexion à la base et la classe Image
require_once __DIR__ . '/db_connection.php';
require_once __DIR__ . '/Classes/Image.php';

// Réponse en JSON
header('Content-Type: application/json');

// Récupère les données envoyées en POST
$data = json_decode(file_get_contents("php://input"), true);
$id = intval($data['id']);
$nom = trim($data['nom']);
$url = trim($data['url']);

// Vérifie que tous les champs nécessaires sont présents
if (!$id || !$nom || !$url) {
    echo json_encode(['success' => false, 'message' => 'Champs manquants']);
    exit;
}

try {
    // Met à jour une image en base avec les nouvelles données
    $image = new Image($pdo);
    $image->updateImage($id, $nom, $url);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erreur : ' . $e->getMessage()
    ]);
}
?>
