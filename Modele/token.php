<?php
// Démarre la session PHP
session_start(); 

// Si aucun token CSRF n'existe dans la session, on en crée un nouveau
if (empty($_SESSION['csrf_token'])) {
    // Génère un token aléatoire sécurisé de 32 octets converti en chaîne hexadécimale
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// On renvoie le token CSRF au format JSON
echo json_encode(['token' => $_SESSION['csrf_token']]);
