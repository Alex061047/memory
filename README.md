# Jeu Memory

Un jeu Memory dynamique et personnalisable en JavaScript, PHP et MySQL, avec une gestion des utilisateurs, des scores et des images stockées en base de données. Le jeu est accessible aux utilisateurs connectés et non connectés et affiche aux joueurs connectés leur meilleur temps à battre.

---

## Fonctionnalités principales

- Jeu de Memory à 16 cartes (8 paires), avec affichage dynamique.
- Chargement des images de cartes depuis la base de données.
- Chronomètre en temps réel pour suivre la durée de la partie.
- Enregistrement du meilleur temps pour chaque joueur connecté.
- Connexion/inscription sécurisée avec mots de passe hashés.
- Interface d’administration pour modifier les images du jeu.

---

## Technologies utilisées

- **Front-end :**
  - HTML5, CSS3
  - JavaScript (DOM, fetch, events)

- **Back-end :**
  - PHP (programmation orientée objet pour une architecture modulaire et maintenable)
  - MySQL (base de données relationnelle)
  - PDO pour des requêtes sécurisées
  - Token CSRF pour la sécurité renforcée lors de l'envoi du score

- **Divers :**
  - Sessions PHP pour la gestion des utilisateurs
  - API internes pour les échanges AJAX (`get_images.php`, `score.php`, etc.)

---

## Structure du projet

Memory/
|-- assets/
│ |-- style.css                     # Feuille de styles CSS
|-- Controleur/
│ |-- script.js                     # Script principal JavaScript pour la logique du jeu
│ |-- timer.js                      # Gestion du chronomètre côté client
|-- Modele/
│ |-- Classes/
│ │ |-- Image.php                   # Classe gérant les images
│ │ |-- Score.php                   # Classe gérant la logique des scores
│ │ |-- Utilisateur.php             # Classe gérant les utilisateurs
│ |-- db_connection.php             # Configuration et connexion à la base de données MySQL via PDO
│ |-- get_images.php                # API pour récupérer les images stockées en base de données
│ |-- get_meilleur_score.php        # API pour récupérer le meilleur score d’un utilisateur
│ |-- score.php                     # API pour enregistrer un score
│ |-- auth.php                      # Gestion de l’authentification
|-- index.php                       # Page principale
|-- README.md                       # Page actuelle
|-- .env                            # Variables d’environnement
|-- .gitignore                      # Fichiers ignorés par Git 
|-- composer.json                   # Configuration des dépendances
|-- composer.lock                   # Version des dépendances


---

## Gestion des utilisateurs

- Un utilisateur peut s’inscrire ou se connecter depuis la page d’accueil.
- Le mot de passe est sécurisé avec `password_hash()` et `password_verify()`.
- Une fois connecté, le joueur peut jouer et enregistrer son meilleur score.

---

## Base de données

Le projet s’appuie sur 3 tables :

- `utilisateurs(id, email, mot_de_passe, role)`
- `scores(id, utilisateur_id, meilleur_temps)`
- `images(id, nom, url)`

---

## Fonctionnement du jeu

1. Au chargement de la page, les images sont récupérées depuis la base de données via `get_images.php`.
2. Les cartes sont doublées, mélangées, puis affichées.
3. Le chronomètre démarre automatiquement.
4. Si toutes les paires sont trouvées :
   - Le chrono s’arrête.
   - Le temps est envoyé via `score.php` pour enregistrement.
   - Si c’est un nouveau record, la base est mise à jour.
5. Le meilleur score est toujours affiché via `get_meilleur_score.php`.

---

---

## Sécurité

- Utilisation de requêtes préparées avec PDO pour prévenir les injections SQL.
- Validation des données à la fois côté client (JavaScript) et côté serveur (PHP) pour éviter les entrées malveillantes.
- Gestion des sessions PHP sécurisée pour l'authentification des utilisateurs.
- Mise en place d'un token CSRF (Cross-Site Request Forgery) afin de protéger les requêtes sensibles, comme l’enregistrement des scores.
- Contrôle d’accès basé sur les rôles utilisateurs pour limiter les actions selon les permissions (joueur, administrateur).

---

## Auteur

Projet réalisé dans le cadre de la formation chez Studi pour l'obtention du Titre Professionnel Développeur Web et Web Mobile.

