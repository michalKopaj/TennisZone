<?php

require_once __DIR__ . '/../core/Database.php';

class Comment {

    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function forArticle($articleId) {
        $sql = "SELECT c.*, u.username
                FROM comments c
                JOIN users u ON u.id = c.user_id
                WHERE c.article_id = :article_id AND c.is_approved = 1
                ORDER BY c.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['article_id' => $articleId]);
        return $stmt->fetchAll();
    }

    public function all() {
        $sql = "SELECT c.*, u.username, a.title AS article_title
                FROM comments c
                JOIN users u ON u.id = c.user_id
                JOIN articles a ON a.id = c.article_id
                ORDER BY c.created_at DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function toggleApproval($id) {
        $sql = "UPDATE comments SET is_approved = 1 - is_approved WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM comments WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
}
