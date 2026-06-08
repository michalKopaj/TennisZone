<?php

require_once __DIR__ . '/../core/Database.php';

class Player {

    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function all() {
        $sql = "SELECT * FROM players ORDER BY ranking ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function find($id) {
        $sql = "SELECT * FROM players WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function delete($id) {
        $sql = "DELETE FROM players WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
public function create($data) {
        $sql = "INSERT INTO players (name, country, ranking, birth_date, bio)
                VALUES (:name, :country, :ranking, :birth_date, :bio)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'name'       => $data['name'],
            'country'    => $data['country'],
            'ranking'    => $data['ranking'] ?? null,
            'birth_date' => $data['birth_date'] ?? null,
            'bio'        => $data['bio'] ?? ''
        ]);

        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $sql = "UPDATE players
                SET name = :name,
                    country = :country,
                    ranking = :ranking,
                    birth_date = :birth_date,
                    bio = :bio
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id'         => $id,
            'name'       => $data['name'],
            'country'    => $data['country'],
            'ranking'    => $data['ranking'] ?? null,
            'birth_date' => $data['birth_date'] ?? null,
            'bio'        => $data['bio'] ?? ''
        ]);
    }
}
