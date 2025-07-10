<?php
class Utilisateur {
  private $pdo;

  // Constructeur connexion PDO
  public function __construct($pdo) {
    $this->pdo = $pdo;
  }

  // Méthode de connexion
  public function seConnecter($email, $mot_de_passe) {
    // Préparation de la requête SQL sécurisée
    $stmt = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);

    // Récupération de l'utilisateur
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification du mot de passe avec password_verify
    if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
      return $user;
    }

    // Échec de l’authentification
    return false;
  }
}
?>
