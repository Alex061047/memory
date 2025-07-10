<?php
// Démarre la session PHP
session_start();

// Importe fichiers de connexion et la classe Score
require_once './db_connection.php';
require_once './Classes/Score.php';

// Réponse en JSON
header('Content-Type: application/json');

// Lecture du corps JSON de la requête POST et décodage en tableau associatif PHP
$data = json_decode(file_get_contents("php://input"), true);

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user']['id'])) {
  echo json_encode(['success' => false, 'message' => 'Non connecté']);
  exit;
}

// Vérification que le token CSRF est présent et correspond
if (!isset($data['csrf_token']) || $data['csrf_token'] !== $_SESSION['csrf_token']) {
    // Si le token est absent ou ne correspond pas, on refuse la requête
    http_response_code(403); 
    echo json_encode(["message" => "Échec de la vérification CSRF."]); 
    exit; 
}

// Récupération du temps envoyé
$data = json_decode(file_get_contents("php://input"), true);
$temps = intval($data['temps']);

// Enregistrement du score
$score = new Score($pdo);
$score->enregistrerScore($_SESSION['user']['id'], $temps);

echo json_encode(['success' => true]);
