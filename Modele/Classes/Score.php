<?php
class Score {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Enregistre le score si c’est un nouveau meilleur temps
     */
    public function enregistrerScore($utilisateur_id, $temps) {
        // Vérifie si un score existe déjà pour cet utilisateur
        $stmt = $this->pdo->prepare("SELECT meilleur_temps FROM scores WHERE utilisateur_id = ?");
        $stmt->execute([$utilisateur_id]);
        $actuel = $stmt->fetchColumn();

        if ($actuel === false) {
            // Aucun score encore enregistré → insertion
            $insert = $this->pdo->prepare("INSERT INTO scores (utilisateur_id, meilleur_temps) VALUES (?, ?)");
            $insert->execute([$utilisateur_id, $temps]);
        } elseif ($temps < $actuel) {
            // Nouveau meilleur temps → mise à jour
            $update = $this->pdo->prepare("UPDATE scores SET meilleur_temps = ? WHERE utilisateur_id = ?");
            $update->execute([$temps, $utilisateur_id]);
        }
    }

    /**
     * Récupère le meilleur temps de l’utilisateur
     */
    public function getMeilleurScore($utilisateur_id) {
        $stmt = $this->pdo->prepare("SELECT meilleur_temps FROM scores WHERE utilisateur_id = ?");
        $stmt->execute([$utilisateur_id]);
        return $stmt->fetchColumn();
    }
}
?>
