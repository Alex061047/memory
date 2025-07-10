<?php
class Image {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getImages() {
        $stmt = $this->pdo->query("SELECT url FROM images");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function updateImage($id, $url) {
        $stmt = $this->pdo->prepare("UPDATE images SET url = ? WHERE id = ?");
        $stmt->execute([$url, $id]);
    }
}
?>