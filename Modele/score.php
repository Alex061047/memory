<?php
// Démarre la session PHP
session_start();

// Importe fichiers de connexion et la classe Score
require_once './db_connection.php';
require_once './Classes/Score.php';

// Réponse en JSON
header('Content-Type: application/json');

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user']['id'])) {
  echo json_encode(['success' => false, 'message' => 'Non connecté']);
  exit;
}

// Récupération du temps envoyé
$data = json_decode(file_get_contents("php://input"), true);
$temps = intval($data['temps']);

// Enregistrement du score
$score = new Score($pdo);
$score->enregistrerScore($_SESSION['user']['id'], $temps);

echo json_encode(['success' => true]);
