<?php
// Démarre une session (stock identité))
session_start();

// Inclusion de la connexion PDO et la classe Utilisateur
require_once __DIR__ . '/../Modele/db_connection.php';
require_once __DIR__ . '/../Modele/Classes/Utilisateur.php';

// Création d'une instance de la classe Utilisateur
$utilisateur = new Utilisateur($pdo);

// Récupération des champs envoyés par le formulaire
$email = $_POST['email'] ?? '';
$mot_de_passe = $_POST['mot_de_passe'] ?? '';
$action = $_POST['action'] ?? '';

// Nettoyage des entrées
$email = trim($email);
$mot_de_passe = trim($mot_de_passe);

// Vérifie que les champs sont remplis
if (empty($email) || empty($mot_de_passe)) {
  $_SESSION['message'] = "Veuillez remplir tous les champs.";
  header('Location: ../index.php');
  exit;
}

// Vérifie si le format de l'email est valide
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $_SESSION['message'] = "Adresse email invalide.";
  header('Location: ../index.php');
  exit;
}

// Gestion inscription ou connexion
if ($action === 'inscription') {
  // Vérifie si l'utilisateur existe déjà
  $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
  $stmt->execute([$email]);

  if ($stmt->fetch()) {
    $_SESSION['message'] = "Un compte avec cet email existe déjà.";
    header('Location: ../index.php');
    exit;
  }

  // Hash du mot de passe
  $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

  // Insertion du nouvel utilisateur (par défaut rôle = joueur)
  $insert = $pdo->prepare("INSERT INTO utilisateurs (email, mot_de_passe, role) VALUES (?, ?, 'joueur')");
  $insert->execute([$email, $mot_de_passe_hash]);

  $_SESSION['message'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
  header('Location: ../index.php');
  exit;

} elseif ($action === 'connexion') {
  // Connexion via la classe Utilisateur
  $user = $utilisateur->seConnecter($email, $mot_de_passe);

  if ($user) {
    // Authentification réussie
  $_SESSION['user'] = [
    'id' => $user['id'],
    'email' => $user['email'],
    'role' => $user['role']
  ];
  
  if ($user['role'] === 'admin') {
    header('Location: ../Vue/admin.php');
  } else {
    header('Location: ../index.php');
  }
  exit;
}


} else {
  // Action inconnue
  $_SESSION['message'] = "Action non reconnue.";
  header('Location: ../index.php');
  exit;
}
