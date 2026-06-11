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

  
    public function delete($id) {
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
}
