<?php
// Démarre la session PHP
session_start();

// Importe fichier de connexion
require_once './db_connection.php';

// Réponse en JSON
header('Content-Type: application/json');

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user']['id'])) {
  echo json_encode(['meilleur_temps' => null]);
  exit;
}

$utilisateur_id = $_SESSION['user']['id'];

// Récupère le meilleur temps dans la table `scores`
$stmt = $pdo->prepare("SELECT meilleur_temps FROM scores WHERE utilisateur_id = ?");
$stmt->execute([$utilisateur_id]);
$result = $stmt->fetch();

echo json_encode(['meilleur_temps' => $result ? $result['meilleur_temps'] : null]);
