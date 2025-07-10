<?php
class Image {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupère uniquement les URL
    public function getUrls() {
        $stmt = $this->pdo->query("SELECT url FROM images");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Récupère toutes les images pour l'admin
    public function getAllImages() {
        $stmt = $this->pdo->query("SELECT id, nom, url FROM images");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Met à jour le nom et l'URL d'une image par ID
    public function updateImage($id, $nom, $url) {
        $stmt = $this->pdo->prepare("UPDATE images SET nom = ?, url = ? WHERE id = ?");
        $stmt->execute([$nom, $url, $id]);
    }
}
?>
