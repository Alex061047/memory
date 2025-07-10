<?php
// Démarre la session PHP 
session_start();

// Importe fichiers de connexion et la classe Image
require_once __DIR__ . '/db_connection.php';
require_once __DIR__ . '/Classes/Image.php';

// Réponse au format JSON
header('Content-Type: application/json');

try {
    $image = new Image($pdo);
    $images = $image->getAllImages(); // Récupère id, nom, url

    echo json_encode([
        'success' => true,
        'images' => $images
    ]);
} catch (Exception $e) {
    // Envoie une réponse JSON avec les images récupérées
    echo json_encode([
        'success' => false,
        'message' => 'Erreur serveur : ' . $e->getMessage()
    ]);
}
?>
