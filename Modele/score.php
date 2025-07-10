<?php
session_start();
require_once './db_connection.php';
require_once './Classes/Score.php';

header('Content-Type: application/json');


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
