<?php
session_start();

// Récupération d’un message d’erreur si présent (ex: mauvaise connexion)
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Memory Game</title>

  <link rel="stylesheet" href="assets/style.css" />
</head>
<body>

  <!-- Titre du jeu -->
  <h1>Memory Game</h1>
  
  <!-- Formulaire de connexion/inscription -->
  <section class="auth-section">
    <form method="POST" action="./Modele/auth.php" class="form-auth">
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="mot_de_passe" placeholder="Mot de passe" required />
      
      <!-- Boutons connexion et inscription -->
      <button type="submit" name="action" value="connexion">Connexion</button>
      <button type="submit" name="action" value="inscription">Inscription</button>
    </form>

    <!-- Affichage du message d'erreur -->
    <?php if (!empty($message)) : ?>
      <p class="erreur-message" style="color:red;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
  </section>

  <!-- Timer + Score -->
<div class="text-center mt-4">
  <h3 id="timer">Temps : 0s</h3>
  <h4 id="meilleur-score" class="text-success"></h4>
</div>

  <!-- Plateau de jeu -->
  <div id="game-board"></div>

  <!-- Script principal -->
  <script src="Controleur/timer.js"></script>
  <script src="Controleur/script.js"></script>
  
</body>
</html>
