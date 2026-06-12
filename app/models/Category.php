<?php

namespace App\Models;

use App\Core\Database;

class Category {

    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }


    public function all() {
        $sql = "SELECT * FROM categories";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function create($name) {
    $sql = "INSERT INTO categories (name, slug) VALUES (:name, :slug)";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        'name' => $name,
        'slug' => $this->generateSlug($name)
    ]);
}

private function generateSlug($name) {
    $slug = strtolower($name);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim($slug, '-');
    return $slug;
}
  
    public function delete($id) {
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
}
