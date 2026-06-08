<?php

require_once __DIR__ . '/../core/Database.php';

class Tournament {

    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function all() {
        $sql = "SELECT * FROM tournaments ORDER BY start_date DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function find($id) {
        $sql = "SELECT * FROM tournaments WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function delete($id) {
        $sql = "DELETE FROM tournaments WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
  
public function create($data) {
        $sql = "INSERT INTO tournaments (name, location, surface, start_date, end_date, prize_money, description)
                VALUES (:name, :location, :surface, :start_date, :end_date, :prize_money, :description)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'name'        => $data['name'],
            'location'    => $data['location'],
            'surface'     => $data['surface'],
            'start_date'  => $data['start_date'],
            'end_date'    => $data['end_date'],
            'prize_money' => $data['prize_money'] ?? null,
            'description' => $data['description'] ?? ''
        ]);

        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $sql = "UPDATE tournaments
                SET name = :name,
                    location = :location,
                    surface = :surface,
                    start_date = :start_date,
                    end_date = :end_date,
                    prize_money = :prize_money,
                    description = :description
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id'          => $id,
            'name'        => $data['name'],
            'location'    => $data['location'],
            'surface'     => $data['surface'],
            'start_date'  => $data['start_date'],
            'end_date'    => $data['end_date'],
            'prize_money' => $data['prize_money'] ?? null,
            'description' => $data['description'] ?? ''
        ]);
    }
}