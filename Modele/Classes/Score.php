<?php
class Score {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Met à jour le meilleur temps si battu
    public function enregistrerScore($utilisateur_id, $temps) {
        $stmt = $this->pdo->prepare("SELECT meilleur_temps FROM utilisateurs WHERE id = ?");
        $stmt->execute([$utilisateur_id]);
        $actuel = $stmt->fetchColumn();

        if ($actuel === null || $temps < $actuel) {
            $update = $this->pdo->prepare("UPDATE utilisateurs SET meilleur_temps = ? WHERE id = ?");
            $update->execute([$temps, $utilisateur_id]);
        }
    }

    public function getMeilleurScore($utilisateur_id) {
        $stmt = $this->pdo->prepare("SELECT meilleur_temps FROM utilisateurs WHERE id = ?");
        $stmt->execute([$utilisateur_id]);
        return $stmt->fetchColumn();
    }
}
?>