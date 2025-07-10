<?php
session_start();
require_once './db_connection.php';
require_once './Classes/Score.php';

header('Content-Type: application/json');

if (!isset($_SESSION['utilisateur']['id'])) {
  echo json_encode(['meilleur_temps' => null]);
  exit;
}

$score = new Score($pdo);
$best = $score->getMeilleurScore($_SESSION['utilisateur']['id']);
echo json_encode(['meilleur_temps' => $best]);
?>
