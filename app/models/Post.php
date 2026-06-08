<?php

require_once __DIR__ . '/../core/Database.php';

class Post {

    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function all() {
        $sql = "SELECT * FROM articles ORDER BY created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function find($id) {
        $sql = "SELECT * FROM articles WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function delete($id) {
        $sql = "DELETE FROM articles WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
public function create($data) {
        $sql = "INSERT INTO articles (category_id, author_id, title, slug, perex, content, image, is_published, published_at)
                VALUES (:category_id, :author_id, :title, :slug, :perex, :content, :image, :is_published, :published_at)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'category_id'  => $data['category_id'],
            'author_id'    => $data['author_id'],
            'title'        => $data['title'],
            'slug'         => $this->generateSlug($data['title']),
            'perex'        => $data['perex'],
            'content'      => $data['content'],
            'image'        => $data['image'] ?? null,
            'is_published' => $data['is_published'] ?? 0,
            'published_at' => $data['is_published'] ? date('Y-m-d H:i:s') : null
        ]);

        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $sql = "UPDATE articles
                SET category_id = :category_id,
                    title = :title,
                    perex = :perex,
                    content = :content,
                    is_published = :is_published
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id'           => $id,
            'category_id'  => $data['category_id'],
            'title'        => $data['title'],
            'perex'        => $data['perex'],
            'content'      => $data['content'],
            'is_published' => $data['is_published'] ?? 0
        ]);
    }

    private function generateSlug($title) {
        $slug = strtolower($title);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim($slug, '-');

        return $slug;
    }
}
